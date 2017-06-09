<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Aws\Sns\SnsClient;
use DB;

class EnviarSMSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envío de mensajes de texto programados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
    }

    
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->enviarSms();
    }
    
    
    public function enviarSms(){
        $mensajecanalmensaje = \App\MensajeCanalmensajeModel::where([
                'estado'=>'procesado',
                 'canalmensaje_idcanalmensaje'=>1,
                ])->get();
        

        if(sizeof($mensajecanalmensaje)>0){
            
            foreach($mensajecanalmensaje as $mensajecanal){
                try{
                    DB::beginTransaction();
                    
                    $mensaje = \App\MensajeModel::find($mensajecanal->mensaje_idmensaje);
                    
                    $mensajesms = \App\MensajeSmsModel::where([
                        'mensaje_idmensaje'=>$mensajecanal->mensaje_idmensaje,
                        'estado'=>'activo',
                    ])->get();
                    
                    if(sizeof($mensajesms)>0){
                        foreach($mensajesms as $sms){
                            $respuesta = $this->sendSMS(['numero'=>$sms->telefono,'texto'=>$mensaje->asunto.". ".$mensaje->mensaje]);
                            
                            $temp = \App\MensajeSmsModel::find($sms->idmensaje_sms);
                            $temp->fechaenvio = date('Y-m-d h:i:s');
                            $temp->MessageId = $respuesta['MessageId'];
                            $temp->statusCode = $respuesta["@metadata"]["statusCode"];
                            $temp->estado='enviado';
                            $temp->save();
                        }
                    }
                    
                    
                    $temp = \App\MensajeCanalmensajeModel::find($mensajecanal->idmensaje_canalmensaje);
                    $temp->estado='enviado';
                    $temp->save();
                    
                    DB::commit();
                } catch (Exception $ex) {
                    DB::rollBack();
                }
                
            }
        }
    }
    
    public function sendSMS($mensaje){
        $client = SnsClient::factory([
                                'region' => env('AWS_REGION', 'us-east-1'),
                                'version' => 'latest',
                                'credentials' => [
                                                'key'    => 'AKIAJSJ6IRYC2G6GX4PQ',
                                                'secret' => 'biV74jeT/eHQMDLKOVvnBf1BhsS/o24S+cqrbakO'
                                ],
                        ]);

        $mensaje['numero'] = '+57' . preg_replace("/[^0-9]/","", str_replace('+57','',$mensaje['numero']));

        $args = [
                        'Message' => $mensaje['texto'],
                        'PhoneNumber' => $mensaje['numero'],
                        /*'MessageAttributes' => [
                         'AWS.SNS.SMS.SenderID' => [
                         'DataType' => 'String',
                         'StringValue' =>  '3168094241'
                         ]
                         ]*/
                        ];

        
        return $client->publish($args);

    }
    
}
