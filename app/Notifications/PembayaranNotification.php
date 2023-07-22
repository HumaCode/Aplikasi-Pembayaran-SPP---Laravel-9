<?php

namespace App\Notifications;

use App\Services\WhacenterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class PembayaranNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $pembayaran;
    public function __construct($pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // $url = 'https://app.whacenter.com/api/send';
        // $ch = curl_init($url);
        // $url2 = URL::temporarySignedRoute(
        //     'login.url',
        //     now()->addDays(10),
        //     [
        //         'pembayaran_id' => $this->pembayaran->id,
        //         'user_id' => $notifiable->id,
        //         'url' => route('pembayaran.show', $this->pembayaran->id),
        //     ]
        // );

        // $nohp = $notifiable->nohp;
        // $pesan = "Halo Operator. ```\n" .
        //     "Ada Pembayaran Tagihan SPP yang Masuk. ```\n"  .
        //     "```\n" .
        //     $this->pembayaran->wali->name .  " Telah melakukan pembayaran tagihan. ```\n" .
        //     "```\n" .
        //     "Untuk melihat info pembayaran, klik link berikut ```\n" . $url2 .

        //     "\n JANGAN BERIKAN LINK INI KE SIAPAPUN.!!";

        // $chunks = str_split($pesan, 1000);




        // $data = array(
        //     'device_id' => 'a235f4ac1bc1a5b0ded8110cd4a1e082',
        //     'number' => $nohp,
        //     // 'message' => $pesan,
        // );

        // foreach ($chunks as $index => $chunk) {
        //     $data['message'] = $chunk;
        //     $payload = $data;

        //     curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     $result = curl_exec($ch);

        //     echo "Pesan ke-" . ($index + 1) . " berhasil dikirim.\n";
        // }
        // curl_close($ch);

        // return ['database', WhacenterChannel::class];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'tagihan_id'        => $this->pembayaran->tagihan_id,
            'wali_id'           => $this->pembayaran->wali_id,
            'pembayaran_id'     => $this->pembayaran->id,
            'title'             => 'Pembayaran Tagihan',
            'messages'          => $this->pembayaran->wali->name . ' telah melakukan pembayaran tagihan.',
            'url'               => route('pembayaran.show', $this->pembayaran->id),
        ];
    }

    public function toWhacenter($notifiable)
    {
        echo $url = URL::temporarySignedRoute(
            'login.url',
            now()->addDays(10),
            [
                'pembayaran_id' => $this->pembayaran->id,
                'user_id' => $notifiable->id,
                'url' => route('pembayaran.show', $this->pembayaran->id),
            ]
        );

        return (new WhacenterService())
            ->to($notifiable->nohp)
            ->line("Halo Operator")
            ->line("Ada Pembayaran Tagihan SPP yang Masuk")
            ->line($this->pembayaran->wali->name .  ' Telah melakukan pembayaran tagihan.')
            ->line('Untuk melihat info pembayaran, klik link berikut' . $url)
            ->line('JANGAN BERIKAN LINK INI KE SIAPAPUN.!!');
    }
}
