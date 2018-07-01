<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Products;
use Auth;
use Request;

/* Modal */

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    // String Constant
    public $account_id = 'account_id';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = Products::where($this->account_id, Auth::user()->account_id)->get();
        //var_export($_POST);

        if ($_POST) {
            echo 'This is a test, this feature does not work.';
        }
//        function ExportFile($records) {
//            $heading = false;
//                if(!empty($records))
//                  foreach($records as $row) {
//                    if(!$heading) {
//                      // display field/column names as a first row
//                      echo implode("\t", array_keys($row)) . "\n";
//                      $heading = true;
//                    }
//                    echo implode("\t", array_values($row)) . "\n";
//                  }
//                return view('product.index');
//                exit;
//        }
//        if(isset($_POST["ExportType"]))
//        {
//
//            switch($_POST["ExportType"])
//            {
//                case "export-to-excel" :
//                    // Submission from
//                    $filename = $_POST["ExportType"] . ".xls";
//                    //header("Content-Type: application/vnd.ms-excel");
//                    //header("Content-Disposition: attachment; filename=\"$filename\"");
//                    ExportFile($products);
//                    //$_POST["ExportType"] = '';
//                    return view('product.index');
//                    exit();
//                default :
//                    return view('product.index');
//                    die("Unknown action : ".$_POST["action"]);
//                    break;
//            }
//        }
        return view('product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required|max:60',
            'item_name' => 'required|max:255'
        ]);

        $data = $request->all();
        $data[$this->account_id] = Auth::user()->account_id;

        Products::create($data);

        return redirect('/product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (Auth::user()->hasRole('manager')) {
            try {
                Products::where('id', $id)->where($this->account_id, Auth::user()->account_id)->delete();
            } catch (\Illuminate\Database\QueryException $e) {
                return response('Cannot delete this product because it is currently being referenced elsewhere.', 409);
            }

        } else {
            return response('Forbidden.', 403);
        }

        return redirect('/product');
    }
}
