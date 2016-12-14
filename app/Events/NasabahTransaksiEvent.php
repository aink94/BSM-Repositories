<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NasabahTransaksiEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $nama_nasabah;
    public $nama_koperasi;
    public $tanggal_transaksi;
    public $jumlah_transaksi;
    public $jenis_transaksi;

    public function __construct(array $payload)
    {
        $this->nama_nasabah = $payload['nama_nasabah'];
        $this->nama_koperasi = $payload['nama_koperasi'];
        $this->jenis_transaksi = $payload['jenis_transaksi'];
        $this->tanggal_transaksi = $payload['tanggal_transaksi'];
        $this->jumlah_transaksi = $payload['jumlah_transaksi'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return['nasabah_transaksi'] ;//new PrivateChannel('channel-name');
    }
}
