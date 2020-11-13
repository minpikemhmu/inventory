<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class SeenNotification extends Notification
{
    use Queueable;
protected $seennoti;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($seennoti)
    {
        $this->seennoti=$seennoti;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        //dd($this->seennoti);
        $seennoti=$this->seennoti;
        
         

        $notifications=DB::table('notifications')->select('data')->get();

      // dd(count($notifications));


        /*if(count($notifications)>0){
            //dd("hi");
            foreach ($notifications as $noti) {
            # code...
            $notiarray=json_decode($noti->data);

            //dd($notiarray);

            foreach ($notiarray as $value) {
               for ($i=0; $i <count($value); $i++) { 
                   # code...
                //dd($value[$i]->id);

                for ($i=0; $i <count($seennoti) ; $i++) { 
                    # code...
                    //dd($seennoti[$i]->id);
                    if($seennoti[$i]->id!=$value[$i]->id){
                        //dd("hi");
                        return [
                         'ways'=>$this->seennoti,
                    ];
                    }
                }
               }
            }
        }
        }else{*/
            //dd("hi");
            return [
                         'ways'=>$this->seennoti,
               ]; 
               //dd("hi");
      /*  }*/
        
       
        
    }
}
