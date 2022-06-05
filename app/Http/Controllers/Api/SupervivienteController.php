<?php

namespace App\Http\Controllers\Api;
use DB;

use App\Item;
use App\Recurso;
use App\Intercambio;
use App\Superviviente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupervivienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $superviviente;

    public function __construct(Superviviente $superviviente) {
        $this->superviviente = $superviviente;
    }

    public function index()
    {
        //
                $supervivientes = ['info' => $this->superviviente->all()];
      
              return response()->json($supervivientes);

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
        //return $request;
            $superviviente = $request->all();
            $id=$this->superviviente->create($superviviente)->id;

            $superviviente = Superviviente::find($id);
            $info['superviviente'] = $superviviente;
           // return response()->json($info);
            $recursos = $request->recursos;
            $contador=0;
            foreach ($recursos as $recurso) {
                
             $id_item = $recurso['item'];
             $cantidades= $recurso['cantidad'];

             //insertando recursos
             $recursonuevo = new Recurso; 
             $recursonuevo->item_id = $id_item;
             $recursonuevo->superviviente_id=$id;
             $recursonuevo->cantidad=$cantidades;
             $recursonuevo->save();
             ///

              $contador++; 
            }
            return response()->json($info);

            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Superviviente  $superviviente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $superviviente = Superviviente::find($id);

        if (!$superviviente) {
            return response()->json([]);
        }
        

        $info['superviviente'] = $superviviente;
        return response()->json($info);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Superviviente  $superviviente
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Superviviente  $superviviente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //return $request;
        $latitud = $request->latitud;
            $longitud = $request->longitud;

            $superviviente = Superviviente::find($id);
            $superviviente->latitud = $latitud;
            $superviviente->longitud = $longitud;
            $superviviente->save();
            $info['superviviente'] = $superviviente;
            return response()->json($info);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Superviviente  $superviviente
     * @return \Illuminate\Http\Response
     */
    
    public function reporteInfectado(Request $request)
    {
       //return $request;
       $supervivientereportado = $request->supervivientereportado;
       $supervivientereporte= $request->supervivientereporte;

       if($supervivientereportado == $supervivientereporte){
           return response()->json(["mensaje"=>"No te puedes autoreportar"]);
       }


       $superviviente = Superviviente::find($supervivientereportado);
       $supervivientereporte = Superviviente::find($supervivientereporte);

       $distancia = $this->distance($superviviente->latitud,$superviviente->longitud,$supervivientereporte->latitud,$supervivientereporte->longitud,"K");
       
       if($distancia >= 1)
       {
           return response()->json(["mensaje"=>"No estas a menos de 1 kilometro de distancia"]);
       }
        
        if (!$superviviente) {
            return response()->json([]);
        }
       $vecesreportado=$superviviente->reportado;
       $vecesreportado++;
       $superviviente->reportado=$vecesreportado; 
       $superviviente->save();
        if($superviviente->reportado == 3){ 
                if ($superviviente->infecado == false) {
                    $superviviente->infectado = true;
                    $superviviente->save();
                    $info['superviviente'] = $superviviente;
                    return response()->json($info);
                }
    
        }
        
        
        $info['superviviente'] = $superviviente;
        return response()->json($info);
        

        
    }


    public function transacciones(Request $request)
    {
            //return $request;
    
    $transaccionid=date('dmYHis');
    //return $transaccionid;
        if($request->sobreviviente1_id == $request->sobreviviente2_id )
        { return response()->json(["mensaje"=>"No te puedes hacer autotransacciones"]);          
        }
    // verificar que no este infectado alguno

    $sobreviviente1 = Superviviente::find($request->sobreviviente1_id);
    $sobreviviente2 = Superviviente::find($request->sobreviviente2_id);

      if($sobreviviente1->infectado == 1 OR $sobreviviente2->infectado == 1 )
      {
        return response()->json(["mensaje"=>"No te puedes hacer transacciones entre supervivientes infectados"]); 
      }

   // verificar que los items que ofrecen los tengan
   $sobreviviente1_puntos=0;
     foreach ($request->sobreviviente1 as $recursoss1){
        $item = $recursoss1['item'];
        $cantidad= $recursoss1['cantidad'];
        $recursosdesobreviviente1 = Recurso::where("superviviente_id","=",$request->sobreviviente1_id)->where('item_id', $item)->where('cantidad',">=", $cantidad)->get();
        if($recursosdesobreviviente1->count() < 1 )
        {
            return response()->json(["mensaje"=>"El sobreviviente 1 -No se cuenta con el item o no se cuenta con suficiente cantidad del recurso"]);
        }   
        $itemvalor= Item::find($item);
        $sobreviviente1_puntos = $sobreviviente1_puntos + ($itemvalor->puntos* $cantidad) ;
      // return $recursosdesobreviviente1;
    }
    $sobreviviente2_puntos=0;
    foreach ($request->sobreviviente2 as $recursoss2){
        $item = $recursoss2['item'];
        $cantidad= $recursoss2['cantidad'];
        $recursosdesobreviviente2 = Recurso::where("superviviente_id","=",$request->sobreviviente2_id)->where('item_id', $item)->where('cantidad',">=", $cantidad)->get();
        if($recursosdesobreviviente2->count() < 1 )
        {
            return response()->json(["mensaje"=>"El sobreviviente 2 -No se cuenta con el item o no se cuenta con suficiente cantidad del recurso"]);
        }   
        $itemvalor= Item::find($item);
        $sobreviviente2_puntos = $sobreviviente2_puntos + ($itemvalor->puntos * $cantidad) ;
        
    }
   // return $sobreviviente1_puntos."--".$sobreviviente2_puntos;
// verificamos si coinciden los puntos de intercambio
    if($sobreviviente1_puntos <> $sobreviviente2_puntos)
    {
        return response()->json(["mensaje"=>"Los puntos de la transaccion no son iguales"]);
    }
    //return $sobreviviente1_puntos."--".$sobreviviente2_puntos;
   // hacer la transaccion
            ///// Pasamos del 2 al 1
            foreach ($request->sobreviviente2 as $recursoss2){
                    $item = $recursoss2['item'];
                    $cantidad= $recursoss2['cantidad'];
                    $recursosdesobreviviente2 = Recurso::where("superviviente_id","=",$request->sobreviviente2_id)->where('item_id', $item)->first();
                    $cantidadnuevo=$recursosdesobreviviente2->cantidad - $cantidad;
                    $recursosdesobreviviente2->cantidad=$cantidadnuevo;
                    $recursosdesobreviviente2->save();
                    $recursosdesobreviviente1 = Recurso::where("superviviente_id","=",$request->sobreviviente1_id)->where('item_id', $item)->first();
                    //si existe el recurso
                    if($recursosdesobreviviente1) {
                        $cantidadnuevo=$recursosdesobreviviente1->cantidad + $cantidad;
                        $recursosdesobreviviente1->cantidad=$cantidadnuevo;
                        $recursosdesobreviviente1->save();
                    ///si no existe el recurso
                    }else{
                        $recursosdesobreviviente1 =new Recurso; 
                        $recursosdesobreviviente1->item_id = $item;
                        $recursosdesobreviviente1->superviviente_id=$request->sobreviviente1_id;
                        $recursosdesobreviviente1->cantidad=$cantidad;
                        $recursosdesobreviviente1->save();
                    }
                  ///se guarda transaccion
                    $transaccion = new Intercambio;
                    $transaccion->transaccion_id=$transaccionid;
                    $transaccion->superviviente_envia_id=$request->sobreviviente2_id;
                    $transaccion->superviviente_recibe_id=$request->sobreviviente1_id;
                    $transaccion->item_id =$item;
                    $transaccion->cantidad=$cantidad;
                    $transaccion->save();
                  ///  

            }
        ///
        ///// Pasamos del 1 al 2
        foreach ($request->sobreviviente1 as $recursoss1){
            $item = $recursoss1['item'];
            $cantidad= $recursoss1['cantidad'];
            $recursosdesobreviviente1 = Recurso::where("superviviente_id","=",$request->sobreviviente1_id)->where('item_id', $item)->first();
            $cantidadnuevo=$recursosdesobreviviente1->cantidad - $cantidad;
            $recursosdesobreviviente1->cantidad=$cantidadnuevo;
            $recursosdesobreviviente1->save();
            $recursosdesobreviviente2 = Recurso::where("superviviente_id","=",$request->sobreviviente2_id)->where('item_id', $item)->first();
            //si existe el recurso
            if($recursosdesobreviviente2) {
                $cantidadnuevo=$recursosdesobreviviente2->cantidad + $cantidad;
                $recursosdesobreviviente2->cantidad=$cantidadnuevo;
                $recursosdesobreviviente2->save();
            ///si no existe el recurso
            }else{
                $recursosdesobreviviente2 =new Recurso; 
                $recursosdesobreviviente2->item_id = $item;
                $recursosdesobreviviente2->superviviente_id=$request->sobreviviente2_id;
                $recursosdesobreviviente2->cantidad=$cantidad;
                $recursosdesobreviviente2->save();
            }
             ///se guarda transaccion
             $transaccion = new Intercambio;
             $transaccion->transaccion_id=$transaccionid;
             $transaccion->superviviente_envia_id=$request->sobreviviente1_id;
             $transaccion->superviviente_recibe_id=$request->sobreviviente2_id;
             $transaccion->item_id =$item;
             $transaccion->cantidad=$cantidad;
             $transaccion->save();
           ///
    }
///
   //
   $recursosdesobreviviente2 = Recurso::where("superviviente_id","=",$request->sobreviviente2_id)->get();
   $recursosdesobreviviente1 = Recurso::where("superviviente_id","=",$request->sobreviviente1_id)->get();
    return response()->json(["mensaje"=>"Transacción Exitosa"]);    
    
     /*foreach ($recursosdesobreviviente1 as $recursoss1){
                 
        $recursoss1_env = $request->sobreviviente1;
        $contador=0;
        foreach ($recursoss1_env as $recurso) {

            if( $recurso['item'] == $recuesoss1['item'])
            {
                if( $recurso['cantidad'] <= $recuesoss1['cantidad'])
                {
                    //si cuenta con item y la cantidad suficiente
                }else{
                    $ban1=1;
                }


            }else{
                $ban1=1;
            }
         
     }*/

     return json_encode($recursosdesobreviviente1);
   //
        return $request;       
        
        //
    }


////API DE REPORTES
    
   ///Porcentaje de infectados ( % infectados, % No infectads , Total supervivientes , Total infectados )

    public function infectados()
    {
        //
        $supervivientes = Superviviente::all();
        $total_supervivientes=$supervivientes->count();
        $infectados=Superviviente::where("infectado","=",1)->get();
        $total_infectados=$infectados->count();

        $porcentaje_infectados=($total_infectados * 100) / $total_supervivientes;
       $total_noinfectado = 100 - $porcentaje_infectados;
        return response()->json(array("porcentaje_infectados" => $porcentaje_infectados,"porcentaje_noinfectado" => $total_noinfectado,"total_supervivientes" => $total_supervivientes,"total_infectados" => $total_infectados));

    }

///Porcentaje de infectados ( % infectados, % No infectads , Total supervivientes , Total infectados )

public function items()
{
    //
    $data=[];
    $items = Item::all();
    $total_items=$items->count();
    foreach($items as $item)
    {
          
        //$supervivientes = Recurso::()->superviviente;
        
        //$supervivientes->superviviente;
     $cantidad_item = Recurso::where("item_id","=",$item->id)->with('superviviente')->get();
     $cantidad_item_t= $cantidad_item->where('superviviente.infectado', 0)->count();
     $cantidad_item_sum = $cantidad_item->where('superviviente.infectado', 0)->sum("cantidad");
     // calcular los infectados
     $cantidad_item_sum_infectados = $cantidad_item->where('superviviente.infectado', 1)->sum("cantidad");
     $puntos_perdidos = $cantidad_item_sum_infectados * $item->puntos;
      
                         
    $promedio_items=$cantidad_item_sum/$cantidad_item_t; 
     //return response()->json(array("id_item"=> $item->id , "nombre_item" => $item->descripcion , "total_item_recurso" => $cantidad_item->count() , "cantidad_item_recurso" => $cantidad_item_sum,"promedio_items"=>$promedio_items));
     $array_item=array("id_item"=> $item->id , "nombre_item" => $item->descripcion , "total_item_recurso" => $cantidad_item_t , "cantidad_item_recurso" => $cantidad_item_sum,"promedio_items"=>$promedio_items,"cantidad_items_infectados"=>$cantidad_item_sum_infectados,"puntos_perdidos_infectados"=>$puntos_perdidos);
     array_push($data, $array_item);
    }
    return $data;

    //return response()->json(array("porcentaje_infectados" => $porcentaje_infectados,"porcentaje_noinfectado" => $total_noinfectado,"total_supervivientes" => $total_supervivientes,"total_infectados" => $total_infectados));

}


public function puntosinfectados(){
   $data=[];
    $infectados = Superviviente::where("infectado","=",1)->get();
    
    foreach($infectados as $infectado)
    { 
        $recursos = Recurso::where("superviviente_id","=",$infectado->id)->with('item')->get();
        $puntos_totales=0;   
        foreach($recursos as $recurso )
        {
            $puntos_recurso=$recurso->cantidad * $recurso->item->puntos;
            $puntos_totales=$puntos_totales + $puntos_recurso;
        }
        $cantidad_recursos=$recursos->sum("cantidad");
       // return $puntos_totales;

        $array_item=array("id_infectado"=> $infectado->id , "nombre_infectado" => $infectado->nombre , "total_puntos_perdidos" => $puntos_totales , "cantidad_item_perdidos" => $cantidad_recursos);
        array_push($data, $array_item); 
    }
    return $data;


}

//////
///funcion para medir la distancia entre dos puntos
    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
 
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
       
        if ($unit == "K") {
          return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
          } else {
              return $miles;
            }
      }
    


}