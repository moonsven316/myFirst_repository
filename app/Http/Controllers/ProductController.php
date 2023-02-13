<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Product;
use App\Models\Machine;
use App\Models\Error;

class ProductController extends Controller
{
	public function register_products(Request $request)
	{
		$user = User::find(Auth::user()->id);
		Product::where('user_id', $user->id)->delete();

		$req = json_decode($request['asin']);
		$codes = $req->codes;
		foreach ($codes as $c) {
			$product = new Product;
			$product->user_id = $user->id;
			$product->asin = $c->asin;
			// $product->image = $user->image;
			$product->reg_price = $c->price;
			$product->pro = $c->pro;
			$product->price = $c->price;
			$product->tar_price = floor($c->price * $c->pro / 100);
			$product->url = 'https://www.amazon.co.jp/dp/' . $c->asin .'?tag=gnem03010a-22&linkCode=ogi&th=1&psc=1';
			$product->save();
		}
	}

	public function list_product()
	{
		$user = Auth::user();
		$products = Product::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
		return view('mypage.product_list', ['user' => $user, 'products' => $products]);
	}

	public function delete_product()
	{
		$user = Auth::user();
		$products = Product::where('user_id', $user->id);
		$products->delete();
		return;
	}
	
	public function remove_product(Request $request)
	{
		Product::where('id', $request->product_id)->delete();
		return;
	}

	public function scan(Request $request)
	{
		$machine = Machine::find($request);
		dd($machine);
		// return $machine;
	}

	public function csv_down(Request $request)
	{
		$data = "";
		$filename = "";
		$user = Auth::user();

		$data .= "ASIN, 価格, 下落%, Keepa URL, 再通知間隔\n";
		$products = Product::where('user_id', $user->id)->get();
		foreach ($products as $p) {
			$data .= $p['asin'].",".$p['price'].",".$p['pro'].", https://keepa.com/#!product/5-".$p['asin'].",".$user['interval']."\n";
		}
		
		$filename = "監視リスト";
		
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename."_".date("Y-m-d").'.csv"');
		echo $data;
		exit();
	}

	public function stop(Request $request)
	{
		// dd($request);
		// $req = json_decode($request['id']);
		$machine = Machine::find($request->id);
		$machine->round = 0;
		$machine->trk_num = 0;
		$machine->stop = 1;
		$machine->save();
	}

	public function restart(Request $request)
	{
		$machine = Machine::find($request->id);
		$machine->stop = 0;
		$machine->save();
	}
}
