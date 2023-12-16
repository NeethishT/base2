<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use DB;
trait CommonTraits{
    public function getId(){
        return $this->InvProductModel::where(['code'=>'RDGEN','is_active'=>1])->select('id')->first()->id;
    }
    public function paymentAttempts($product,$sdate,$edate){
        $commonPaymentAttemptsQuery = "from inv_lead_payments as ilp 
                                    JOIN inv_leads as il on il.id = ilp.inv_lead_id 
                                    JOIN inv_products as ip on il.inv_product_id = ip.id 
                                    where il.inv_product_id = $product and Date(ilp.created_at) BETWEEN '$sdate 00:00:00' and '$edate 23:59:59'";                           
        $paymentAttempts = DB::select("select count(*) as paymentAttemptsValue $commonPaymentAttemptsQuery")[0]->paymentAttemptsValue;
        $uniqRdPaymentAttempts = DB::select("select count(distinct(inv_lead_id)) as uniqRdPaymentAttemptsValue $commonPaymentAttemptsQuery")[0]->uniqRdPaymentAttemptsValue;
        $successFullPayments = DB::select("select count(*) as count,sum(ilp.payment_amount) as sum $commonPaymentAttemptsQuery and ilp.payment_status ='S'")[0];
        
        return array('paymentattempt'=>$paymentAttempts,
                    'uniqpaymentattempt'=>$uniqRdPaymentAttempts,
                    'successfullpayment'=>$successFullPayments->count??0,
                    'totalamount' => $successFullPayments->sum??0
                );
    }
    public function perPageCount()
    {
        return empty(env('PAGE_COUNT'))===false ? env('PAGE_COUNT') : 10;
    }
    public function searchByLike($request)
    {
        $search =$request->search ?? '';
        $page = $request->page ?? 1;
        $filterItems = $this->when($search != '', function ($query) use ($search) {
            $query->Where($this->search_columns[0],'LIKE','%'.$search.'%');
            for ($i = 1;$i<count($this->search_columns);$i++) {
                    return $query->orwhere($this->search_columns[$i],'LIKE','%'.$search.'%');
            }               
        })->orderBy('updated_at','desc')->paginate($this->perPageCount(), ['*'], 'page', $page);

        return $this->buildPaginateStructure($filterItems);
    }
    public function buildPaginateStructure($data) {
        $content = $data->toArray();
        $replaceableString          = $content['path'].'?page=';
        $content['first_page_url']  = (int) str_replace($replaceableString,'', $content['first_page_url']);
        $content['last_page_url']   = (int) str_replace($replaceableString,'', $content['last_page_url']);
        $content['prev_page_url']   = (int) str_replace($replaceableString,'', $content['prev_page_url']);
        $content['next_page_url']   = (int) str_replace($replaceableString,'', $content['next_page_url']);
        unset($content['last_page']);
        unset($content['path']);
        foreach ($content['links'] as $key => $link){
            unset($content['links'][$key]['url']);
            $content['links'][$key]['label'] = (int) $content['links'][$key]['label'];
        }
        $content['permissions'] = $this->getPermissions();
        return $content;
    }

    public function getPermissions()
    {
        $cachePermissions = Redis::get('PERMISSIONS:' . Auth::user()->id);
        if (isset($cachePermissions)) {
            $rolePermission = json_decode($cachePermissions, false);
        } else {
            $permissions = Auth::user()->permissions;
            $rolePermission = [];
            if (empty($permissions) === false) {
                foreach ($permissions as $permission) {
                    $rolePermission[] = $permission->slug;
                }
            }
        }
        return $rolePermission;
    }
}
