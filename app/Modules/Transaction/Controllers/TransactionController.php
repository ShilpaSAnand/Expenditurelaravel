<?php

namespace App\Modules\Transaction\Controllers;

use Auth;

use Validator;

use  Log;

use Response;

use Carbon\Carbon;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;

use App\Modules\Transaction\Models\UserBank;

use App\Modules\AccountHead\Models\AccountHead;

use App\Modules\Transaction\Models\MoneyVoucher;

use App\Modules\Transaction\Models\MoneyTransaction;

use App\Modules\Transaction\Models\BankTransactionMeta;

class TransactionController extends Controller {

    public function create () {

      $created_by = Auth::user()->id;

      $account_head = AccountHead::whereNotIn('id', [1, 2, 3])->get(); //dd($account_head);

      $bank_details = UserBank::where('user_id', $created_by)->get();         // dd($bank);

      return view('Transaction::transaction-create', compact('account_head', 'bank_details'));

    }

    public function create_transaction (Request $request) {

      $inputs = Input::all(); //Getting All Input For The Request

      $rules = $this->rules();

      $messages = $this->messages();

      $validator = Validator::make($inputs,$rules,$messages);

      if ($validator->fails()) {

        $response = [

            'code' => 400,

            'errors' => $validator->errors(),

            'message' => 'Validation error'

        ];

         return Response::json(['error' => $response], 400);

      } else {

        $created_by = Auth::User()->id;

        $created_on = Carbon::now();

        $transaction_time = Carbon::parse($request->transaction_time);

        $voucher = new MoneyVoucher();

        $voucher->transaction_time = $transaction_time;

        $voucher->created_on =   $created_on;

        $voucher->save();

        $voucher_id = $voucher->id;

        $transaction_type = $request->transaction_type;

        $account_head = $request->account_head;

        $payment_mode = $request->payment_mode;

        $amount =  $request->amount;

        $account_number = $request->account_number;

        $narration = $request->narration;

        $balance = MoneyTransaction::selectRaw('(sum(case when to_account_head = '. $payment_mode.' then amount else 0 end) - sum(case when from_account_head = '. $payment_mode.' then amount else 0 end)) as balance');

        if ($payment_mode == 2) {

           $balance = $balance->join('bank_transaction_meta','money_transaction.id', '=',  'bank_transaction_meta.transaction_id')->where('bank_transaction_meta.bank_id', $account_number);

        }

        $balance_amount = $balance->where('money_transaction.created_by',$created_by)->get();

        if($transaction_type == 1){                  //checking whether income or expensseS

          $transaction = new MoneyTransaction();

          $transaction->voucher_id =  $voucher_id;

          $transaction->amount = $amount;

          $transaction->from_account_head = $account_head ;

          $transaction->to_account_head = $payment_mode;

          $transaction->created_by = $created_by;

          $transaction->narration = $narration;

          $transaction->save();

          if($payment_mode == 2) {

            $bank_transaction = new BankTransactionMeta();

            $bank_transaction->bank_id = $account_number;

            $bank_transaction->transaction_id = $transaction->id;

            $bank_transaction->save();

          }

          $response = [

            'code' => 200,

			'data' => $transaction,

            'message' => 'Transaction  created successfully'

           ];

          return response()->json(['message' => $response], 200);

        } elseif ($transaction_type == 2) {

          $balance = $balance_amount[0]['balance'];

          if($balance >= $amount) {

              $transaction = new MoneyTransaction();

              $transaction->voucher_id =  $voucher_id;

              $transaction->amount = $amount;

              $transaction->from_account_head = $payment_mode;

              $transaction->to_account_head = $account_head ;

              $transaction->created_by = $created_by;

              $transaction->narration = $narration;

              $transaction->save();

              $response = [

                'code' => 200,

				'data' => $transaction,

                'message' => 'Transaction created successfully'

               ];

              return response()->json(['message' => $response], 200);

              // $message = array('type' => 'Success', 'class'=>'alert-success', 'text'=> 'Expenditure Data Added Successfully' );

              // $request->session()->flash('alert-message', $message);

              // return redirect()->route('transaction.show',$transaction->id);

          } else {

            if($payment_mode == 1){

				$response = [

		            'code' => 400,

		            'errors' => 'Available cash is less',

		        ];


              //  $text = 'Available cash is less' ;

            } else if($payment_mode == 2) {

              $response = [

                'code' =>400,

                'error' => 'There is not enough cash in your bank'

              ];

              //$text = 'There is not enough cash in your bank';

            }
			return Response::json(['error' => $response], 400);


          }

        }

      }

    }

    public function store (Request $request) {

      $this->validate($request, ['transaction_time' => 'required|before:'.date('Y-m-d'), 'transaction_type' => 'required', 'account_head' => 'required', 'payment_mode' => 'required', 'amount' => 'required', 'account_number' => 'required_if:payment_mode,2' ], ['account_number.required_if' => 'Select An Account']);

      $created_by = Auth::user()->id;

      $created_on = Carbon::now();

      $transaction_time = $request->transaction_time;

      $voucher = new MoneyVoucher();

      $voucher->transaction_time = $transaction_time;

      $voucher->created_on =   $created_on;

      $voucher->save();

      $voucher_id = $voucher->id;

      $transaction_type = $request->transaction_type;

      $account_head = $request->account_head;

      $payment_mode = $request->payment_mode;

      $amount =  $request->amount;

      $account_number = $request->account_number;

      $request ->flash();

      // $balance = 0;

      // $transaction = (new MoneyTransaction())->getTable();

      $balance = MoneyTransaction::selectRaw('(sum(case when to_account_head = '. $payment_mode.' then amount else 0 end) - sum(case when from_account_head = '. $payment_mode.' then amount else 0 end)) as balance');

      if($payment_mode == 2) {

         $balance = $balance->join('bank_transaction_meta','money_transaction.id', '=',  'bank_transaction_meta.transaction_id')->where('bank_transaction_meta.bank_id', $account_number);

      }

      $balance_amount = $balance->where('money_transaction.created_by',$created_by)->get();



      // $balance = MoneyTransaction::sum(case  )

      $narration = $request->narration;

      // if(in_array(1, $transaction_type)){

      if($transaction_type == 1){                  //checking whether income or expensseS

          $transaction = new MoneyTransaction();

          $transaction->voucher_id =  $voucher_id;

          $transaction->amount = $amount;

          $transaction->from_account_head = $account_head ;

          $transaction->to_account_head = $payment_mode;

          $transaction->created_by = $created_by;

          $transaction->narration = $narration;

          $transaction->save();

          if($payment_mode == 2) {

            $bank_transaction = new BankTransactionMeta();

            $bank_transaction->bank_id = $account_number;

            $bank_transaction->transaction_id = $transaction->id;

            $bank_transaction->save();

          }

          $message = array('type' => 'Success', 'class'=>'alert-success', 'text'=> 'Expenditure Data Added Successfully' );

          $request->session()->flash('alert-message', $message);

          return redirect()->route('transaction.show',$transaction->id);

      } elseif ($transaction_type == 2) {

          $balance = $balance_amount[0]['balance'];

          if($balance >= $amount) {

              $transaction = new MoneyTransaction();

              $transaction->voucher_id =  $voucher_id;

              $transaction->amount = $amount;

              $transaction->from_account_head = $payment_mode;

              $transaction->to_account_head = $account_head ;

              $transaction->created_by = $created_by;

              $transaction->narration = $narration;

              $transaction->save();

              $message = array('type' => 'Success', 'class'=>'alert-success', 'text'=> 'Expenditure Data Added Successfully' );

              $request->session()->flash('alert-message', $message);

              return redirect()->route('transaction.show',$transaction->id);

          } else {

            if($payment_mode == 1){

                $text = 'Available cash is less' ;

            } else if($payment_mode == 2) {

                $text = 'There is not enough cash in your bank';

            }

            $message = array('type' => 'Error!', 'class'=>'alert-danger', 'text'=> $text );

            $request->session()->flash('alert-message', $message);

            return redirect()->route('transaction.create');

          }

      }

    }

    public function show($id) {

      $created_by = Auth::user()->id;

      $transaction_table = (new MoneyTransaction())->getTable();

      $transaction_show = MoneyTransaction::select('users.name','money_transaction.*','ah_from.category as from_category', 'ah_to.category as to_category')->join('users', 'money_transaction.created_by', '=', 'users.id')->join('account_head as ah_from', 'money_transaction.from_account_head', '=', 'ah_from.id')->join('account_head as ah_to', 'money_transaction.to_account_head', '=', 'ah_to.id')->where('money_transaction.id',$id)->where('money_transaction.created_by', $created_by)->get();
      //dd($transaction_details);
      return view('Transaction::transaction-show', compact('transaction_show'));

    }

    public function show_transaction ($id) {
		$transaction_details=array();

      	$created_by = Auth::user()->id;

      	$transaction_table = (new MoneyTransaction())->getTable();

      	$transaction_show = MoneyTransaction::select('users.name','money_transaction.*','ah_from.category as from_category', 'ah_to.category as to_category')->join('users', 'money_transaction.created_by', '=', 'users.id')->join('account_head as ah_from', 'money_transaction.from_account_head', '=', 'ah_from.id')->join('account_head as ah_to', 'money_transaction.to_account_head', '=', 'ah_to.id')->where('money_transaction.id',$id)->where('money_transaction.created_by', $created_by)->get();

		$transaction_details =['name' => $transaction_show[0]['name'], 'from_category' => $transaction_show[0]['from_category'], 'to_category' => $transaction_show[0]['to_category'], 'amount' => $transaction_show[0]['amount']];

		if($transaction_show) {

            $response = [

                'message' => 'Transaction Details',

                'code' =>200,

                'tasks' => $transaction_details


            ];

            return response()->json(['message' => $response], 200);

        } else {

            $response = [

                'code' =>400,

                'error' => 'Transaction details not found'

            ];

            return response()->json(['error' => $response], 400);

        }

    }

    public function transaction_index (Request $request) {

		$paginate = 3;

		$transaction_type = $request->transaction_type;

		$search_account_head = $request->account_head;

		$payment_mode = $request->payment_mode;

		$date_from = $request->date_from;

		$date_to = $request->date_to;

		$created_by = Auth::user()->id;

		$account_head = AccountHead::whereNotIn('id', [1, 2, 3])->get();

		$transaction = MoneyTransaction::select('users.name','money_transaction.*','ah_from.category as from_category', 'ah_to.category as to_category')->join('users', 'money_transaction.created_by', '=', 'users.id')->join('account_head as ah_from', 'money_transaction.from_account_head', '=', 'ah_from.id')->join('account_head as ah_to', 'money_transaction.to_account_head', '=', 'ah_to.id');

		if($transaction_type == 1) {

			$transaction =  $transaction->whereIn('money_transaction.to_account_head', [1,2]);

		}

		if($transaction_type == 2){

			$transaction =  $transaction->whereIn('money_transaction.from_account_head', [1,2]);

		}

		if($search_account_head != ''){
		// dd($search_account_head);
			$transaction =  $transaction->where('money_transaction.from_account_head', $search_account_head)->orWhere('money_transaction.to_account_head', $search_account_head);
		}

		if($payment_mode != ""){

			$transaction =  $transaction->where('money_transaction.from_account_head', $payment_mode)->orWhere('money_transaction.to_account_head', $payment_mode);

		}

		if(($date_from <= $date_to) && ($date_from !="") && ($date_to != "")) {

			$start = date("Y-m-d",strtotime($request->input('date_from')));
			$end = date("Y-m-d",strtotime($request->input('date_to')."+1 day"));
			$transaction =  $transaction->join('money_voucher', 'money_transaction.voucher_id', '=', 'money_voucher.id')->whereBetween('money_voucher.transaction_time',[$start,$end]);

		}

		$transaction_index_array =  $transaction->where('money_transaction.created_by', $created_by)->paginate($paginate);

		$firstRowOnThisPage = $transaction_index_array->currentPage() * $transaction_index_array->perPage() - $transaction_index_array->perPage() + 1;
		$lastRowOnThisPage = $firstRowOnThisPage + ($paginate-1);

		$pagination = ['perPage' => $transaction_index_array->perPage(), 'currentPage' => $transaction_index_array->currentPage(), 'lastPage' => $transaction_index_array->lastPage(), 'firstRowOnThisPage' => $firstRowOnThisPage, 'lastRowOnThisPage' => $lastRowOnThisPage, 'total' => $transaction_index_array->total()];

		foreach($transaction_index_array as $transaction_details) {

			$transaction_index[] = $transaction_details;

		}

		if ($transaction_index_array) {

          $response = ['code' => 200,
                        'transaction_index' => $transaction_index,
						'pagination' => $pagination,
                        'message' => 'Transaction details'];

          return response()->json(['message' => $response], 200);

        }
    }

    public function index(Request $request) {

		$transaction_type = $request->transaction_type;

		$search_account_head = $request->account_head;

		$payment_mode = $request->payment_mode;

		$date_from = $request->date_from;

		$date_to = $request->date_to;

		$request ->flash();

		$created_by = Auth::user()->id;

		$account_head = AccountHead::whereNotIn('id', [1, 2, 3])->get();

		$transaction = MoneyTransaction::select('users.name','money_transaction.*','ah_from.category as from_category', 'ah_to.category as to_category')->join('users', 'money_transaction.created_by', '=', 'users.id')->join('account_head as ah_from', 'money_transaction.from_account_head', '=', 'ah_from.id')->join('account_head as ah_to', 'money_transaction.to_account_head', '=', 'ah_to.id');

		if($transaction_type == 1) {

			$transaction =  $transaction->whereIn('money_transaction.to_account_head', [1,2]);

		}

		if($transaction_type == 2){

			$transaction =  $transaction->whereIn('money_transaction.from_account_head', [1,2]);

		}

		if($search_account_head != ''){
		// dd($search_account_head);

			$transaction =  $transaction->where('money_transaction.from_account_head', $search_account_head)->orWhere('money_transaction.to_account_head', $search_account_head);
		}

		if($payment_mode != ""){

			$transaction =  $transaction->where('money_transaction.from_account_head', $payment_mode)->orWhere('money_transaction.to_account_head', $payment_mode);

		}

		if(($date_from <= $date_to) && ($date_from !="") && ($date_to != "")) {

			$start = date("Y-m-d",strtotime($request->input('date_from')));
			$end = date("Y-m-d",strtotime($request->input('date_to')."+1 day"));
			$transaction =  $transaction->join('money_voucher', 'money_transaction.voucher_id', '=', 'money_voucher.id')->whereBetween('money_voucher.transaction_time',[$start,$end]);

		}

	    $transaction_index =  $transaction->where('money_transaction.created_by', $created_by)->paginate(2);
	     // dd($transaction_index);

	    return view('Transaction::transaction-index', compact('transaction_index', 'account_head'));

    }

    public function funds(Request $request) {

      $bank_name = $request->bank_name;

      $transaction_time = $request->transaction_time;

      $request->flash();

      $created_by = Auth::user()->id;

      $bank_details = UserBank::where('user_id', $created_by)->get();

      $balance_cash = MoneyTransaction::selectRaw('(sum(case when to_account_head = 1 then amount else 0 end) - sum(case when from_account_head = 1 then amount else 0 end)) as balance');

      if($transaction_time !="") {

        $transaction_time = date("Y-m-d",strtotime($request->input('transaction_time')));

        $balance_cash = $balance_cash->join('money_voucher', 'money_transaction.voucher_id', '=', 'money_voucher.id')->where('money_voucher.transaction_time', '<=', $transaction_time);
      }

      $cash_balance = $balance_cash->get();
      // dd($cash_balance);

      $balance_bank = MoneyTransaction::selectRaw('(sum(case when to_account_head = 2 then amount else 0 end) - sum(case when from_account_head = 2 then amount else 0 end)) as balance');
      // dd($bank_balance);
      if($bank_name != '') {

        $balance_bank = $balance_bank->join('bank_transaction_meta','money_transaction.id', '=',  'bank_transaction_meta.transaction_id')->where('bank_transaction_meta.bank_id', $bank_name);

      }

      if($transaction_time !="") {

        $transaction_time = date("Y-m-d",strtotime($request->input('transaction_time')));

        $balance_bank = $balance_bank->join('money_voucher', 'money_transaction.voucher_id', '=', 'money_voucher.id')->where('money_voucher.transaction_time', '<=', $transaction_time);
      }

      $bank_balance = $balance_bank->get();

      // dd($bank_balance);

      return view('Transaction::transaction-funds', compact('cash_balance', 'bank_balance', 'bank_details'));

    }



	public function transaction_funds(Request $request) {

      $bank_name = $request->bank_name;

      $transaction_time = $request->transaction_time;

      $created_by = Auth::User()->id;

      // $bank_details = UserBank::where('user_id', $created_by)->get();

      $balance_cash = MoneyTransaction::selectRaw('(sum(case when to_account_head = 1 then amount else 0 end) - sum(case when from_account_head = 1 then amount else 0 end)) as cash_balance');

      if($transaction_time !="") {

        $transaction_time = date("Y-m-d",strtotime($request->input('transaction_time')));

        $balance_cash = $balance_cash->join('money_voucher', 'money_transaction.voucher_id', '=', 'money_voucher.id')->where('money_voucher.transaction_time', '<=', $transaction_time);
      }

      $cash_balance = $balance_cash->get();
	  $cash_balance = $cash_balance[0]['cash_balance'];

      $balance_bank = MoneyTransaction::selectRaw('(sum(case when to_account_head = 2 then amount else 0 end) - sum(case when from_account_head = 2 then amount else 0 end)) as balance');
      // dd($bank_balance);
      if($bank_name != '') {

        $balance_bank = $balance_bank->join('bank_transaction_meta','money_transaction.id', '=',  'bank_transaction_meta.transaction_id')->where('bank_transaction_meta.bank_id', $bank_name);

      }

      if($transaction_time !="") {

        $transaction_time = date("Y-m-d",strtotime($request->input('transaction_time')));

        $balance_bank = $balance_bank->join('money_voucher', 'money_transaction.voucher_id', '=', 'money_voucher.id')->where('money_voucher.transaction_time', '<=', $transaction_time);
      }

      $bank_balance = $balance_bank->get();


		$response = ['code' => 200,
					  'balance' => $cash_balance,
					  'bank_balance' => $bank_balance[0]['balance'],
					  'message' => 'Fund balance'];

		return response()->json(['message' => $response], 200);



      return view('Transaction::transaction-funds', compact('cash_balance', 'bank_balance', 'bank_details'));

    }

	public function getRelavantDatas() {

		$bank_details_data = array();

		$created_by = Auth::User()->id;

		$account_head = AccountHead::select('id', 'category')->whereNotIn('id', [1, 2, 3])->get();

		$bank_details = UserBank::select('id','bank_name','account_number')->where('user_id', $created_by)->get();

		foreach($bank_details as $details) {

			$bank_details_data[] = ['id' => $details->id, 'bank_account' => $details->bank_name."-".$details->account_number];
		}

		$response = ['code' => 200,
					  'account_head' => $account_head,
					  'account_details' => $bank_details_data,
					  'message' => 'datas'];

		return response()->json(['message' => $response], 200);

	}


    public function rules () {

      return [

        'transaction_time' => 'required',
        'transaction_type' => 'required',
        'account_head' => 'required',
        'payment_mode' => 'required',
        'amount' => 'required',
        'account_number' => 'required_if:payment_mode,2'
      ];

    }

    public function messages () {

      return[

      'required' => 'The :attribute field is required.',
      'account_number.required_if' => 'Select An Account',

      ];

    }



}
