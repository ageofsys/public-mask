<?php

namespace App\Http\Controllers;

use App\PublicMask\Api\Clients\SimpleClient;
use App\Repositories\PublicMaskApiRepository;
use App\Store;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected $repository;

    /**
     * StoreController constructor.
     * @param $publicMaskRepository
     */
    public function __construct(PublicMaskApiRepository $publicMaskRepository)
    {
        $this->repository = $publicMaskRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keywords = collect(explode(" ", $request->keyword));
        $keywords = $keywords->filter();


        $parameters = $request->query->all();

        $ascdesc = $request->asc ? "asc" : "desc";
        $orderCoulmn = $request->order ?: null;

        $query = Store::query();

        if (isset($request->remain_stat) && in_array($request->remain_stat, ["plenty", "some", "few", "empty"])) {

//            $query->whereHas("sales", function ($query2) use ($request) {
//                $query2->where("remain_stat", "=", $request->remain_stat);
//            });

        }

        if ($orderCoulmn) {
            $query->orderBy($request->order, $ascdesc);
        }

        if ( ! $keywords->isEmpty()) {
            foreach ($keywords as $keyword) {
                $query->where(function ($query2) use ($keyword) {
                    $query2->orWhere("addr", "like", "%$keyword%");
                });
            }
        }

        $stores = $query->paginate(15);

        return view("store.index")->with([
            "stores" => $stores,
            "parameters" => $parameters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
