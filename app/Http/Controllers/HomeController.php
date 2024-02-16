<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $apiUrlMenu = "http://tes-web.landa.id/intermediate/menu";
        $apiUrlTransaksi = "http://tes-web.landa.id/intermediate/transaksi";

        $client = new Client();

        // Mengambil data dari API menu
        $responseMenu = $client->get($apiUrlMenu);
        $menuData = json_decode($responseMenu->getBody(), true);

        //inisialisasi variabel
        $transaksiData = [];
        $totalPerBulanSemuaMenu = [];
        $totalSetahunPerMenu = [];
        $totalSetahun = 0;

        $tahun = $request->has('tahun') ? $request->tahun : 0;

        $transaksiResponse = $client->get($apiUrlTransaksi, ['query' => ['tahun' => $tahun]]);
        if ($transaksiResponse->getStatusCode() === 200) {
            $transaksiRawData = json_decode($transaksiResponse->getBody(), true);

            if (empty($transaksiRawData)) {
                return view('layouts.index', [
                    'menuData' => $menuData,
                    'transaksiData' => [],
                    'totalPerBulanSemuaMenu' => [],
                    'totalSetahunPerMenu' => [],
                    'totalSetahun' => 0,
                    'tahun' => $tahun,
                ]);
            }

            // Menginisialisasi array total per bulan untuk setiap menu
            $totalPerMenuPerBulan = [];

            //sum per bulan untuk setiap menu
            foreach ($transaksiRawData as $transaksi) {
                $tanggal = Carbon::parse($transaksi['tanggal']);
                $bulan = $tanggal->translatedFormat('F'); // Format bulan dalam teks dalam bahasa yang disesuaikan (misalnya "Januari" dalam bahasa Indonesia)
                $menu = $transaksi['menu'];
                $total = $transaksi['total'];

                // sum per menu
                if (!isset($totalPerMenuPerBulan[$menu][$bulan])) {
                    $totalPerMenuPerBulan[$menu][$bulan] = 0;
                }
                $totalPerMenuPerBulan[$menu][$bulan] += $total;

                // sum per menu per bulan
                if (!isset($totalPerBulanSemuaMenu[$bulan])) {
                    $totalPerBulanSemuaMenu[$bulan] = 0;
                }
                $totalPerBulanSemuaMenu[$bulan];

                // sum menu per tahun
                if (!isset($totalSetahunPerMenu[$menu])) {
                    $totalSetahunPerMenu[$menu] = 0;
                }
                $totalSetahunPerMenu[$menu] += $total;

                // sum total transaksi setahun
                $totalSetahun += $total;
            }

            // Mengonversi array total per bulan untuk setiap menu menjadi format yang diinginkan
            foreach ($totalPerMenuPerBulan as $menu => $totalPerBulan) {
                foreach ($totalPerBulan as $bulan => $total) {
                    $transaksiData[] = [
                        'menu' => $menu,
                        'bulan' => $bulan,
                        'total_per_bulan' => $total,
                    ];

                    // Tambahkan total transaksi saat ini ke total transaksi untuk bulan tersebut
                    if (!isset($totalPerBulanSemuaMenu[$bulan])) {
                        $totalPerBulanSemuaMenu[$bulan] = 0;
                    }
                    $totalPerBulanSemuaMenu[$bulan] += $total;
                }
            }

        }

        // Menggabungkan data dari kedua API dan mengirimnya ke tampilan
        return view('layouts.index', [
            'menuData' => $menuData,
            'transaksiData' => $transaksiData,
            'totalPerBulanSemuaMenu' => $totalPerBulanSemuaMenu,
            'totalSetahunPerMenu' => $totalSetahunPerMenu,
            'totalSetahun' => $totalSetahun,
            'tahun' => $tahun,
        ]);
    }
}
