<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        td,
        th {
            font-size: 11px;
        }
    </style>


    <title>TES - Venturo Camp Tahap 2</title>
</head>

<body>
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option value="">Pilih Tahun</option>
                                    <option value="2021" >2021</option>
                                    <option value="2022" >2022</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary">
                                Tampilkan
                            </button>
                             <a href="http://tes-web.landa.id/intermediate/menu" target="_blank" rel="Array Menu" class="btn btn-secondary">
                                Json Menu
                            </a>
                            <a href="http://tes-web.landa.id/intermediate/transaksi?tahun=2022" target="_blank" rel="Array Transaksi" class="btn btn-secondary">
                                Json Transaksi
                            </a>
                            <a href="https://tes-web.landa.id/intermediate/download?path=example.php" class="btn btn-secondary">Download Example</a>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    @if($tahun)
                    <table class="table table-hover table-bordered" style="margin: 0;">
                        <thead>
                            <tr class="table-dark">
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu</th>
                                <th colspan="12" style="text-align: center;">Periode Pada {{$tahun}}</th>
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total</th>


                            </tr>
                            <tr class="table-dark">
                                <th style="text-align: center;width: 75px;">Jan</th>
                                <th style="text-align: center;width: 75px;">Feb</th>
                                <th style="text-align: center;width: 75px;">Mar</th>
                                <th style="text-align: center;width: 75px;">Apr</th>
                                <th style="text-align: center;width: 75px;">Mei</th>
                                <th style="text-align: center;width: 75px;">Jun</th>
                                <th style="text-align: center;width: 75px;">Jul</th>
                                <th style="text-align: center;width: 75px;">Ags</th>
                                <th style="text-align: center;width: 75px;">Sep</th>
                                <th style="text-align: center;width: 75px;">Okt</th>
                                <th style="text-align: center;width: 75px;">Nov</th>
                                <th style="text-align: center;width: 75px;">Des</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php
                                $groupedMenus = collect($menuData)->groupBy('kategori');
                                $groupBulan = collect($transaksiData)->groupBy('tanggal');
                                @endphp
                               @foreach($groupedMenus as $kategori => $menus)
                               <tr>
                                   <td class="table-secondary" colspan="{{ count($groupBulan) + 13 }}"><b>{{ ucfirst($kategori) }}</b></td>
                               </tr>
                               @foreach($menus as $menu)
                                   <tr>
                                       <td>{{ $menu['menu'] }}</td>
                                       @foreach ($transaksiData as $item)
                                           @if ($item['menu'] === $menu['menu'])
                                               <td>{{ number_format($item['total_per_bulan'], 0, ',', '.') }}</td>
                                           @endif
                                       @endforeach
                                       <td>{{ number_format($totalSetahunPerMenu[$menu['menu']], 0, ',', '.') }}</td>
                                   </tr>
                               @endforeach
                           @endforeach


                           <tr class="table-dark">
                               <td><b>Total</b></td>
                               @foreach ($totalPerBulanSemuaMenu as $total)
                                   <td>{{ number_format($total, 0, ',', '.') }}</td> <!-- Menampilkan total per bulan -->
                               @endforeach
                                    <td>{{ number_format($totalSetahun, 0, ',', '.') }}</td>
                           </tr>
                        </tbody>
                    </table>
                    @else
                    <p>Silakan pilih tahun terlebih dahulu</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>

</html>
