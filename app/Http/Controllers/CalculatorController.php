<?php

namespace App\Http\Controllers;

use App\Models\CodeCar\Calculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class CalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function calc_function_get()
    {
         return view('codecar.error_page');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function calc_function(Request $request)
    {
        $benefitPercentage=$request['sectorBenefit'];
        $first_installment=($request['r-first_batch']/100)*($request['price']);
        $last_installment=($request['r-last_batch']/100)*($request['price']);
        $installment_years=($request['sectorBenefit']<$request['$sectorInstallment']?$request['$sectorInstallment']:$request['r-installment']);
        $Adminstrativefeecost=($request['price']-$first_installment)*$request['sectorAdministrative_fees'];
        $fundingAmount=($request['price']-$first_installment)+$Adminstrativefeecost;

        if($request['sex']=='female'){
            $insurancePrice = ($request['price'] *  ($request['insurance_female'] / 100))*$request['r-installment'];
            }
            elseif($request['sex']=='male'){
            $insurancePrice = ($request['price'] * ($request['insurance_man'] / 100))*$request['r-installment'];
            }
            else{
                $insurancePrice = 0;
            }
            if ($benefitPercentage == 0)
            $fundingAmountIncludeBenefit =  $fundingAmount-$last_installment + $insurancePrice;
            else
            $fundingAmountIncludeBenefit = ( $fundingAmount *  $benefitPercentage * $installment_years) + $fundingAmount - $last_installment + $insurancePrice;

            $firstBatchIncludeAdministrativeFees = $first_installment + $Adminstrativefeecost;

            $monthlyInstallment = $fundingAmountIncludeBenefit / ($installment_years*12) ;

        $result=[
            'first_installment'=>$first_installment,
            'last_installment'=>$last_installment,
            'installment_years'=>$installment_years,
            'benefitPercentage'=>$request['sectorBenefit'],
            'Adminstrativefeecost'=>$Adminstrativefeecost,
            'fundingAmount'=> $fundingAmount,
            'insurancePrice'=> $insurancePrice,
            'fundingAmountIncludeBenefit'=>$fundingAmountIncludeBenefit,
            'monthlyInstallment'=>$monthlyInstallment,
        ];
        return response()->json(['result' => $result]); 





    //     $calculatorData = json_decode($request, true);
    //     $needed_function = $request["needed_fun"];
    //     $domain_url =$request["src_ur"];
    
    //      $username = $request['Database_connection']['username'];
    //       $host = $request['Database_connection']["servername"];
    //       $password = $request['Database_connection']["password"];
    //       $db_name = $request['Database_connection']["database"];
    //       $calc_data_request = json_decode($request->input('calculator_data'), true);
 
    //      $calc_data = Calculator::where('function_name', $needed_function)->where('domain_url', $domain_url)->first();

    //      if($needed_function==$calc_data['function_name'] && $domain_url==$calc_data['domain_url']){

    //     $pdo = new PDO("mysql:host=$host;port=3306;dbname=$db_name;charset=utf8mb4", $username, $password);

    // //     //  $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=codecar_dev;charset=utf8mb4",'codecar_dev','!+0~Tpv*vpJM',);
    //     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
       
    //     $cars = $pdo->query('SELECT * FROM cars')->fetchAll(PDO::FETCH_ASSOC);
    //     $banks = $pdo->query('SELECT * FROM banks')->fetchAll(PDO::FETCH_ASSOC);

    //     $car = collect($cars)->where('model_id', $calc_data_request['model'])
    //     ->where('brand_id', $calc_data_request['brand'] )
    //     ->where('year', $calc_data_request['year'] )
    //     ->where('gear_shifter',$calc_data_request['gear_shifter'] )
    //     ->first()??$calc_data_request['car'];

    //     $bank= collect($banks)->where('id',$calc_data_request['bank']);

    //     return $bank;
    //     // Execute the custom function
    //     $result = $this->excute_fun($request);

    //     // Return the result
    //     return response()->json(['result' => $result]); 
    //      }
    }
      
public function excute_fun($request){

    $needed_function = $request["needed_fun"];
    $domain_url =$request["src_ur"];

    $script = Calculator::where('function_name', $needed_function)
    ->where('domain_url', $domain_url)
    ->firstOr(function () {
     return ['function_script' => null]; // Return default value if no result is found
     });   
   
      $functionScript = $script['function_script'];
      return $functionScript;
      
}

}
