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
                        @if($tahun >0)
                        <table class="table table-hover table-bordered" style="margin: 0;">
                            <thead>
                                <tr class="table-dark">
                                    <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu</th>
                                    <th colspan="12" style="text-align: center;">Periode Pada {{$tahun}}</th>
                                    <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total</th>
                                </tr>
                                <tr class="table-dark">
                                    @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'] as $month)
                                    <th style="text-align: center;width: 75px;">{{$month}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $groupedMenus = collect($menuData)->groupBy('kategori');
                                $groupBulan = collect($transaksiData)->groupBy('bulan') ->sortBy(function ($value, $key) {
                                    return \Carbon\Carbon::parse($key)->month;
                                });
                                @endphp
                                @foreach($groupedMenus as $kategori => $menus)
                                <tr>
                                    <td class="table-secondary" colspan="{{ count($groupBulan) + 13 }}"><b>{{ ucfirst($kategori) }}</b></td>
                                </tr>
                                @foreach($menus as $menu)
                                    <tr>
                                        <td>{{ $menu['menu'] }}</td>
                                        @php
                                        $dataCount = 0;
                                        @endphp
                                        @foreach ($groupBulan as $bulan => $items)
                                            @php
                                            $totalPerBulan = collect($items)->where('menu', $menu['menu'])->sum('total_per_bulan');
                                            @endphp
                                            <td>{{ $totalPerBulan > 0 ? number_format($totalPerBulan, 0, ',', '.') : '' }}</td>
                                            @php
                                            $dataCount++;
                                            @endphp
                                        @endforeach
                                        @for ($i = $dataCount; $i < 12; $i++)
                                            <td></td>
                                        @endfor
                                        <td style="grid-column: 13;">
                                            <b>{{ isset($totalSetahunPerMenu[$menu['menu']]) ? number_format($totalSetahunPerMenu[$menu['menu']], 0, ',', '.') : '' }}</b>
                                        </td>
                                    </tr>
                                @endforeach
                                @endforeach
                                <tr class="table-dark">
                                <td><b>Total</b></td>
                                @php
                                    $dataCount = count($totalPerBulanSemuaMenu);
                                @endphp

                                @foreach ($totalPerBulanSemuaMenu as $total)
                                    <td>{{ isset($total) ? number_format($total, 0, ',', '.') : '' }}</td>
                                @endforeach

                                @for ($i = $dataCount; $i < 12; $i++)
                                    <td></td>
                                @endfor

                                <td colspan="13">
                                    {{ isset($totalSetahun) ? number_format($totalSetahun, 0, ',', '.') : '' }}
                                </td>
                                </tr>
                            </tbody>
                        </table>
                        @elseif ($tahun == 0)
                        <p></p>
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
