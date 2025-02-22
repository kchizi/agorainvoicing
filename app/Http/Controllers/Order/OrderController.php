<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderRequest;
use App\Model\Order\Invoice;
use App\Model\Order\InvoiceItem;
use App\Model\Order\Order;
use App\Model\Payment\Plan;
use App\Model\Payment\Promotion;
use App\Model\Product\Price;
use App\Model\Product\Product;
use App\Model\Product\Subscription;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $order;
    public $user;
    public $promotion;
    public $product;
    public $subscription;
    public $invoice;
    public $invoice_items;
    public $price;
    public $plan;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $order = new Order();
        $this->order = $order;

        $user = new User();
        $this->user = $user;

        $promotion = new Promotion();
        $this->promotion = $promotion;

        $product = new Product();
        $this->product = $product;

        $subscription = new Subscription();
        $this->subscription = $subscription;

        $invoice = new Invoice();
        $this->invoice = $invoice;

        $invoice_items = new InvoiceItem();
        $this->invoice_items = $invoice_items;

        $plan = new Plan();
        $this->plan = $plan;

        $price = new Price();
        $this->price = $price;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('themes.default1.order.index');
    }

    public function GetOrders()
    {
        return \Datatable::collection($this->order->get())
                        ->addColumn('#', function ($model) {
                            return "<input type='checkbox' value=".$model->id.' name=select[] id=check>';
                        })
                        ->showColumns('created_at')
                        ->addColumn('client', function ($model) {
                            $first = $this->user->where('id', $model->client)->first()->first_name;
                            $last = $this->user->where('id', $model->client)->first()->last_name;

                            return ucfirst($first).' '.ucfirst($last);
                        })
                        ->showColumns('payment_method', 'price_override', 'order_status')
                        ->addColumn('action', function ($model) {
                            return '<a href='.url('orders/'.$model->id.'/edit')." class='btn btn-sm btn-primary'>Edit</a>";
                        })
                        ->searchColumns('name')
                        ->orderColumns('name')
                        ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $clients = $this->user->lists('first_name', 'id')->toArray();
            $product = $this->product->lists('name', 'id')->toArray();
            $subscription = $this->subscription->lists('name', 'id')->toArray();
            $promotion = $this->promotion->lists('code', 'id')->toArray();

            return view('themes.default1.order.create', compact('clients', 'product', 'subscription', 'promotion'));
        } catch (\Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(OrderRequest $request)
    {
        try {
            $this->order->fill($request->input())->save();

            if ($request->input('confirmation') == 1) {
                // do order conformation
            }

            if ($request->input('invoice') == 1) {
                // Generate Invoice
            }

            if ($request->input('email') == 1) {
                // send email to the client
            }

            return redirect()->back()->with('success', \Lang::get('message.saved-successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        try {
            $order = $this->order->where('id', $id)->first();
            $clients = $this->user->lists('first_name', 'id')->toArray();
            $product = $this->product->lists('name', 'id')->toArray();
            $subscription = $this->subscription->lists('name', 'id')->toArray();
            $promotion = $this->promotion->lists('code', 'id')->toArray();

            return view('themes.default1.order.edit', compact('clients', 'product', 'subscription', 'promotion', 'order'));
        } catch (\Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, OrderRequest $request)
    {
        try {
            $order = $this->order->where('id', $id)->first();
            $order->fill($request->input())->save();

            return redirect()->back()->with('success', \Lang::get('message.updated-successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('fails', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        try {
            $ids = $request->input('select');
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $order = $this->order->where('id', $id)->first();
                    if ($order) {
                        $order->delete();
                    } else {
                        echo "<div class='alert alert-danger alert-dismissable'>
                    <i class='fa fa-ban'></i>
                    <b>".\Lang::get('message.alert').'!</b> '.\Lang::get('message.failed').'
                    <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        '.\Lang::get('message.no-record').'
                </div>';
                        //echo \Lang::get('message.no-record') . '  [id=>' . $id . ']';
                    }
                }
                echo "<div class='alert alert-success alert-dismissable'>
                    <i class='fa fa-ban'></i>
                    <b>".\Lang::get('message.alert').'!</b> '.\Lang::get('message.success').'
                    <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        '.\Lang::get('message.deleted-successfully').'
                </div>';
            } else {
                echo "<div class='alert alert-danger alert-dismissable'>
                    <i class='fa fa-ban'></i>
                    <b>".\Lang::get('message.alert').'!</b> '.\Lang::get('message.failed').'
                    <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        '.\Lang::get('message.select-a-row').'
                </div>';
                //echo \Lang::get('message.select-a-row');
            }
        } catch (\Exception $e) {
            echo "<div class='alert alert-danger alert-dismissable'>
                    <i class='fa fa-ban'></i>
                    <b>".\Lang::get('message.alert').'!</b> '.\Lang::get('message.failed').'
                    <button type=button class=close data-dismiss=alert aria-hidden=true>&times;</button>
                        '.$e->getMessage().'
                </div>';
        }
    }

    /**
     * Create orders.
     *
     * @param Request $request
     *
     * @return type
     */
    public function orderExecute(Request $request)
    {
        try {
            $invoiceid = $request->input('invoiceid');
            $execute = $this->executeOrder($invoiceid);
            //dd($execute);
            if ($execute == 'success') {
                return redirect()->back()->with('success', \Lang::get('message.saved-successfully'));
            } else {
                return redirect()->back()->with('fails', \Lang::get('message.not-saved-successfully'));
            }
        } catch (\Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

    /**
     * inserting the values to orders table.
     *
     * @param type $invoiceid
     * @param type $order_status
     *
     * @throws \Exception
     *
     * @return string
     */
    public function executeOrder($invoiceid, $order_status = 'pending')
    {
        try {
            //dd($invoiceid);
            $invoice_items = $this->invoice_items->where('invoice_id', $invoiceid)->get();
            $user_id = $this->invoice->find($invoiceid)->user_id;
            if (count($invoice_items) > 0) {
                // dd($invoice_items);
                foreach ($invoice_items as $item) {
                    if ($item) {
                        $product = $this->getProductByName($item->product_name)->id;
                        $price = $item->subtotal;
                        $qty = $item->quantity;
                        $serial_key = $this->checkProductForSerialKey($product);
                        $plan_id = $this->getPrice($product)->subscription;

                        $order = $this->order->create([
                            'invoice_id'     => $invoiceid,
                            'client'         => $user_id,
                            'order_status'   => $order_status,
                            'serial_key'     => $serial_key,
                            'product'        => $product,
                            'price_override' => $price,
                            'qty'            => $qty,
                        ]);
                        $this->addSubscription($order->id, $plan_id);
                    }
                }
            }

            return 'success';
        } catch (\Exception $ex) {
            dd($ex);
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * inserting the values to subscription table.
     *
     * @param type $orderid
     * @param type $planid
     *
     * @throws \Exception
     */
    public function addSubscription($orderid, $planid)
    {
        try {
            $days = $this->plan->where('id', $planid)->first()->days;
            //dd($days);
            if ($days > 0) {
                $dt = \Carbon\Carbon::now();
                //dd($dt);
                $user_id = \Auth::user()->id;
                $ends_at = $dt->addDays($days);
            } else {
                $ends_at = '';
            }
            $this->subscription->create(['user_id' => \Auth::user()->id, 'plan_id' => $planid, 'order_id' => $orderid, 'ends_at' => $ends_at]);
        } catch (\Exception $ex) {
            //dd($ex);
            throw new \Exception('Can not Generate Subscription');
        }
    }

    /**
     * get the price of a product by id.
     *
     * @param type $product_id
     *
     * @throws \Exception
     *
     * @return type collection
     */
    public function getPrice($product_id)
    {
        try {
            return $this->price->where('product_id', $product_id)->first();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * get the product model by name.
     *
     * @param type $name
     *
     * @throws \Exception
     *
     * @return type
     */
    public function getProductByName($name)
    {
        try {
            //dd($name);
            return $this->product->where('name', $name)->first();
        } catch (Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * check wheather the product require serial key or not.
     *
     * @param type $product_id
     *
     * @throws \Exception
     *
     * @return type
     */
    public function checkProductForSerialKey($product_id)
    {
        try {
            $product = $this->product->where('id', $product_id)->first();
            $product_type = $product->type;

            return $this->generateSerialKey($product_type);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    /**
     * generating serial key if product type is downloadable.
     *
     * @param type $product_type
     *
     * @throws \Exception
     *
     * @return type
     */
    public function generateSerialKey($product_type)
    {
        try {
            if ($product_type == 2) {
                $str = str_random(16);
                $str = strtoupper($str);

                return $str;
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
}
