<?php

namespace App\Notifications;

use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use URL;

class TagihanNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $tagihan;
    public function __construct($tagihan)
    {
        $this->tagihan = $tagihan;
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
        // $url2  = URL::temporarySignedRoute(
        //     'login.url',
        //     now()->addDays(10),
        //     [
        //         'tagihan_id' => $this->tagihan->id,
        //         'user_id' => $notifiable->id,
        //         'url' => route('wali.tagihan.show', $this->tagihan->id),
        //     ]
        // );


        // $bulanTagihan = $this->tagihan->tanggal_tagihan->translatedFormat('F Y');
        // $nohp = $notifiable->nohp;
        // $pesan = "Assalammualaikum... ```\n" .
        //     "Berikut kami kirim informasi tagihan spp untuk bulan "  . $bulanTagihan . " atas nama " . $this->tagihan->siswa->nama .
        //     "```\n" .
        //     "Jika sudah melakukan pembayaran, silahkan klik link berikut " . $url2  .
        //     "```\n" .
        //     "Link ini hanya berlaku 3 Hari. " .
        //     "JANGAN BERIKAN LINK INI KE SIAPAPUN.!!";

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
            'tagihan_id'     => $this->tagihan->id,
            'title'             => 'Tagihan SPP ' . $this->tagihan->siswa->nama,
            'messages'          => 'Tagihan SPP Bulan ' . $this->tagihan->tanggal_tagihan->translatedFormat('F Y'),
            'url'               => route('wali.tagihan.show', $this->tagihan->id),
        ];
    }

    public function toWhacenter($notifiable)
    {
        echo $url = URL::temporarySignedRoute(
            'login.url',
            now()->addDays(10),
            [
                'tagihan_id' => $this->tagihan->id,
                'user_id' => $notifiable->id,
                'url' => route('wali.tagihan.show', $this->tagihan->id),
            ]
        );

        $bulanTagihan = $this->tagihan->tanggal_tagihan->translatedFormat('F Y');

        return (new WhacenterService())
            ->to($notifiable->nohp)
            ->line("Assalammualaikum..")
            ->line("Berikut kami kirim informasi tagihan spp untuk bulan " . $bulanTagihan . " atas nama " . $this->tagihan->siswa->nama)
            ->line("Jika sudah melakukan pembayaran, silahkan klik link berikut." . $url)
            ->line("Link ini hanya berlaku 3 Hari.")
            ->line("JANGAN BERIKAN LINK INI KE SIAPAPUN.!!");
    }
}
