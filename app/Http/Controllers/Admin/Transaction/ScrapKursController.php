<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Master\Bank;
use App\Models\Master\Currency;
use App\Models\Transaction\ScrapBi;
use App\Models\Transaction\ScrapBca;
use App\Models\Transaction\ScrapKursDetail;
use Auth;
use DB;
use Illuminate\Http\Request;

class ScrapKursController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create currency|edit currency|delete currency', ['only' => ['index', 'show', 'sourceData']]);
        $this->middleware('permission:create currency', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit currency', ['only' => ['edit', 'update', 'resetPassword']]);
        $this->middleware('permission:delete currency', ['only' => ['destroy']]);
    }

    /**
     * Show list of admin
     *
     * @return view
     */
    public function index()
    {
        $data = [
            'sidebar' => 'scrapKurs',
        ];
        return view('transaction.scrapKurs.index', $data);
    }

    /**
     * Generate data to be shown in datatable
     *
     * @param Request $request
     * @return Response
     */
    public function sourceData(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $offset = $request->start;
        $limit = $request->length;
        $baseQuery = DB::table('kurs_rate')->select('kurs_rate.*');
        $recordsTotal = DB::select(DB::raw('SELECT COUNT(kurs_rate.id) as total FROM kurs_rate USE INDEX (PRIMARY)'))[0]->total;
        $filteredQuery = '';
        $keyword = $request->search['value'];
        $filteredQuery = $baseQuery->where(function ($query) use ($keyword) {
            $query->orWhere('kurs_rate.date', 'like', "%$keyword%");
        });
        $countQuery = 'SELECT COUNT(kurs_rate.id) as total FROM kurs_rate USE INDEX (PRIMARY) WHERE 1';

        $sort = $request->order[0];
        $columns = $request->columns;
        $recordsFiltered = DB::select(DB::raw($countQuery))[0]->total;
        $sortQuery = $filteredQuery->orderBy($columns[$sort['column']]['name'], $sort['dir'])->orderBy('kurs_rate.id', 'desc');
        $data = $sortQuery->skip($offset)->take($limit)->distinct()->get();
        $table['draw'] = $request->draw;
        $table['recordsTotal'] = $recordsTotal;
        $table['recordsFiltered'] = $recordsFiltered;
        $table['data'] = $data;

        return response()->json($table);
    }

    /**
     * Show scrapKurs's detail
     *
     * @param scrapKurs $scrapKurs
     * @return view
     */
    public function show(scrapKurs $scrapKurs)
    {

        $data = [
            'model' => $scrapKurs,
            'a' => $a,
            'sidebar' => 'scrapKurs',
        ];
        return view('transaction.scrapKurs.detail', $data);
    }

    /**
     * Show form to create new scrapKurs
     *
     * @return view
     */
    public function create()
    {
        $bank = Bank::where('status', 1)->get();
        $data = [
            'model' => new scrapKurs(),
            'bank' => $bank,
            'detail' => null,
            'sidebar' => 'scrapKurs',
        ];
        return view('transaction.scrapKurs.form', $data);
    }

    /**
     * Save new scrapKurs
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        if ($request->bank == 'bi') {
            $scrap = $this->scrapbi('https://www.bi.go.id/id/statistik/informasi-kurs/transaksi-bi/Default.aspx');
            // dd($scrap);
            $temp = collect([]);
            $tempAll = collect([]);
            $i = 0;
            $j = 0;
            foreach ($scrap as $key => $s) {
                if ($i == 0) {
                    $temp->put('id_m_currency', $s);
                } else if ($i == 1) {
                    // $temp->put('value', $s);
                } else if ($i == 2) {
                    $temp->put('rate_sell', $s);
                } else if ($i == 3){
                    $temp->put('rate_buy', $s);
                }
                $i++;
                if($s == ""){
                    $tempAll->prepend($temp, $j);
                    $j++;
                    $i = 0;
                    $temp = collect([]);
                }
            }
            $delete = ScrapBi::where('date',date('Y-m-d'))->delete();
            foreach($tempAll as $t){
                $rate_buy = str_replace(".", "", $t['rate_buy']);
                $rate_sell = str_replace(".", "", $t['rate_sell']);
                
                $rate_buy = str_replace(",", ".", $rate_buy);
                $rate_sell = str_replace(",", ".", $rate_sell);
                $model = new ScrapBi();
                $model->date = date('Y-m-d');
                $model->id_m_bank = 'bi';
                $model->id_m_currency = $t['id_m_currency'];
                $model->rate_buy = $rate_buy;
                $model->rate_sell = $rate_sell;
                $model->rate_middle = round(($rate_buy+$rate_sell)/2,2);
                $model->created_at = date('Y-m-d H:i:s');
                $model->save();
            }
        } else if($request->bank == 'bca'){
            $scrap = $this->scrapbca('https://www.bca.co.id/individu/sarana/kurs-dan-suku-bunga/kurs-dan-kalkulator');
            $temp = collect([]);
            $tempAll = collect([]);
            $i = 0;
            $j = 0;
            foreach ($scrap as $key => $s) {
                if ($i == 0) {
                    $temp->put('id_m_currency', $s);
                } else if ($i == 1) {
                    $temp->put('rate_buy', trim(str_replace(".", "",$s)));
                } else if ($i == 2) {
                    $temp->put('rate_sell', trim(str_replace(".", "",$s)));
                } 
                $i++;
                if($i == 7){
                    $tempAll->prepend($temp, $j);
                    $j++;
                    $i = 0;
                    $temp = collect([]);
                }
            }
            // dd($tempAll);
            $delete = ScrapBca::where('date',date('Y-m-d'))->delete();
            foreach($tempAll as $t){
                $rate_buy = str_replace(",", ".", $t['rate_buy']);
                $rate_sell = str_replace(",", ".", $t['rate_sell']);
                $model = new ScrapBca();
                $model->date = date('Y-m-d');
                $model->id_m_bank = 'bca';
                $model->id_m_currency = $t['id_m_currency'];
                $model->rate_buy = $rate_buy;
                $model->rate_sell = $rate_sell;
                $model->rate_middle = round(($rate_buy+$rate_sell)/2,2);
                $model->created_at = date('Y-m-d H:i:s');
                $model->save();
            }
        }
        $this->logActivity($model, null, 'kurs_rate', Auth::user()->id, 'CREATE');
        DB::commit();
        return redirect()->back();
    }

    /**
     * Show form to edit existing scrapKurs
     *
     * @param scrapKurs $scrapKurs
     * @return view
     */
    public function edit($id)
    {
        $scrapKurs = scrapKurs::find($id);
        $detail = scrapKursDetail::join('m_currency', 'm_currency.id', '=', 'kurs_rate_detail.id_m_currency')
            ->join('m_bank', 'm_bank.id', '=', 'id_m_bank')
            ->where('id_kurs_rate', $id)
            ->select('kurs_rate_detail.*', 'm_bank.name as bank', 'm_currency.name as currency')
            ->get();
        $data = [
            'model' => $scrapKurs,
            'detail' => $detail,
            'sidebar' => 'scrapKurs',
        ];
        return view('transaction.scrapKurs.form', $data);
    }

    /**
     * Delete scrapKurs from database
     *
     * @param Request $request
     * @param scrapKurs $scrapKurs
     * @return Response
     */
    public function destroy(Request $request, scrapKurs $scrapKurs)
    {
        $scrapKurs->status = 0;
        $scrapKurs->save();

        $this->logActivity($scrapKurs, null, 'kurs_rate', Auth::user()->id, 'DELETE');
        return redirect('scrapKurs')->with('success', 'Berhasil menghapus data.');
    }

    /**
     * get data Bank
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDataBank(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $string = $request['keyword'];
        $data = Bank::where('status', 1)
            ->get();
        $results = array();
        foreach ($data as $query) {
            $results[] = [
                'id' => $query->id,
                'value' => $query->name,
            ];
        }
        return response()->json($results);
    }

    /**
     * get data Bank and currency
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getDataBankDetail(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }
        $string = $request['keyword'];
        $data = Currency::where('status', 1)
            ->get();
        $results = [
            'data' => $data,
        ];
        return response()->json($results);
    }

    public function scrapbi($url)
    {
        $client = new \Goutte\Client();
        $selector = '#ctl00_PlaceHolderMain_g_6c89d4ad_107f_437d_bd54_8fda17b556bf_ctl00_GridView1 table td';
// create a crawler object from this link
        $crawler = $client->request('GET', $url);

        $csv = '';
        $i = 0;
        // return $result = $crawler->filter('h2 > a')->each(function ($node){
        //     return $posts[] = $node->text();
        // });
        return $crawler->filter($selector)->each(function ($node) use ($csv, $i) {
            // $aa = explode('#', $node->filter('tr td')->text());
            // $csv .= $node->text();
            // global $i, $csv;
            if (($i % 2) == 0) {
                $csv .= trim($node->text());
            }
            if (($i % 2) == 1) {
                $csv .= ', ' . trim(str_replace(",", "", $node->text())) . "\n";
            }
            $i++;

            return $csv;

        });
    }

    public function scrapbca($url)
    {
        $client = new \Goutte\Client();
        $selector = '.kurs-e-rate table td';
        $crawler = $client->request('GET', $url);
        $csv = '';
        $i = 0;
        return $crawler->filter($selector)->each(function ($node) use ($csv, $i) {
            $csv .= $node->text();
            $i++;

            return $csv;

        });
    }
}
