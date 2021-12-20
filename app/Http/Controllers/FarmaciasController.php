<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\farmacias;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;


class FarmaciasController extends Controller
{
    
    
    /**
     * //funcion para buscar los datos de la farmacia 
     * @param $latitud de la farmacia
     * @param $longitud de la farmacia
     * @return $query datos de la consulta a db
     */
    public function farmacia($latitud,$longitud)
    {
        $query=DB::table('farmacias')
            ->where([
                ['latitud','=',$latitud],
                ['longitud','=',$longitud],
            ])
            ->limit(1)
        ->get();

        return $query;
    }

    //retorno de errores
    public function error()
    {
        return response()->json("ha introducido mal un campo por favor revise los datos introducidos");
    }

    
    /**
     * Display a listing of the resource.
     * @param $reques->longitud del usuario
     * @param @relatitud del usuario
     * @return famrcia mas cercana
     */
    public function index(Request $request)
    {
        //farmacia mas cercana con respecto al usuario
        //datos de direccion usuario
        $longitud = $request->longitud;
        $latitud = $request->latitud;   

        if(isset($request->longitud) && !empty($request->longitud) && !empty($request->latitud) && isset($request->latitud) )
        {
            //consulta para traer todas las farmacias
            $farmacia=DB::table('farmacias')
                ->select('id','latitud','longitud')
            ->get();
        
            //convertir el json de la consulta en un array
            $farmaciaArray=json_decode($farmacia,true);
            $distancia=array();

            //calcular la distancia entre el usuario y la farmacias  
            for($i=0;$i<count($farmaciaArray);$i++)
            {
                $lat2=$farmaciaArray[$i]['latitud'];
                $lon2=$farmaciaArray[$i]['longitud'];
                $theta = $longitud - $lon2;
                $dist = sin(deg2rad($latitud)) * sin(deg2rad($lat2)) +  cos(deg2rad($latitud)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;

                $distance=[
                    'distancia'=>($miles*1.609344)*1000,
                    'latitud'=>$farmaciaArray[$i]['latitud'],
                    'longitud'=>$farmaciaArray[$i]['longitud'],

                ];
                array_push($distancia,$distance);


            }

            $min=min($distancia);//seleccionar la distancia mas cercana 

            $consulta=$this->farmacia($min['latitud'],$min['longitud']);//consultar datos de la farmacia

            $farmacia=json_decode($consulta,true);

        
            return response()->json("hay una farmacia disponible a ".round($min['distancia'],2)." metros de tu ubicación el nombre es ".$farmacia[0]['nombre']." la direccion es ".$farmacia[0]['direccion']);
        }else{
            return $this->error();
        }

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
     * @param $request->nombre de la farmacia
     * @param $request->direccion farmacia
     * @param $request->longitud de la farmacia
     * @param $request->longitud de la farmacia
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        

        try{
            
            farmacias::insert([
                'nombre'=>$request->nombre,
                'direccion'=>$request->direccion,
                'longitud'=>$request->longitud,
                'latitud'=>$request->latitud,
                //'created-at'=> now()->toDateTime(),
            ]);
            
           
        }catch(\Illuminate\Database\QueryException $ex){ 
            return $this->error();
        }
          
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\farmacias  $farmacias
     * @return \Illuminate\Http\Response
     */
    public function show(farmacias $farmacias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\farmacias  $farmacias
     * @return \Illuminate\Http\Response
     */
    public function edit(farmacias $farmacias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\farmacias  $farmacias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, farmacias $farmacias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\farmacias  $farmacias
     * @return \Illuminate\Http\Response
     */
    public function destroy(farmacias $farmacias)
    {
        //
    }
}
