<div class="card-body px-0 pb-2">
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        NO
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Puskesmas</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        Januari</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Febuari</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Maret</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        April</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Mei</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Juni</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        July</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Agustus</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        September</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Oktober</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        November</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        Desember</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-9">
                        Aksi</th>

                </tr>
            </thead>
            <tbody>
                @if (isset($puskesmas))
                    @if ($puskesmas->total() != 0)
                        @foreach ($puskesmas as $item)
                            <tr>
                                <td class="align-middle text-center text-sm">
                                    {{$item->No}}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->PUSKESMAS }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->Januari }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->Febuari }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->Maret }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->April }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->Mei }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->Juni }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->July }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->Agustus }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->September }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->Oktober }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->November }}
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{ $item->Desember }}
                                </td>
                                <td>
                                    <a href="{{route('puskesmas.show',$item->No)}}" class="btn btn-primary">Detail</a>
                                </td>
                                
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="align-middle text-center text-sm">
                                Belum ada Produk
                            </td>
                        </tr>
                    @endif
                @else
                    <tr>
                        <td colspan="6" class="align-middle text-center text-sm">
                            Belum ada data pesanan
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer">
    {{ $puskesmas->links('layouts.partials.paginate') }}
</div>
