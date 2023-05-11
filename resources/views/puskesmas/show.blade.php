@extends('layouts.app')

@section('title')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
            </li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><a
                    href="{{ route('puskesmas.index') }}">Puskesmas</a> </li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $puskesmas['puskesmas_name'] }} ({{ $puskesmas['year'] }})</h6>
    </nav>
@endsection

@section('main')
    <div class="container-fluid py-4">
        <div class="row my-4">
            <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>{{ $puskesmas['puskesmas_name'] }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table align-items-center mb-0" style="overflow: scroll">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Bulan
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Stunting
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Distribusi Probabilitas
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Distribusi Komulatif
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Interval Acak
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Angka Acak
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Peramalan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $data = array_slice($puskesmas, 2, 12);
                                @endphp
                                @for ($i = 0; $i <= 11; $i++)
                                <tr>
                                    <td class="align-middle text-center text-sm">{{ date('F', mktime(0, 0, 0, $i+1, 10));  }}</td>
                                    <td class="align-middle text-center text-sm">{{$data[$i]}}</td>
                                    <td class="align-middle text-center text-sm">{{$probabilitas[$i]}}</td>
                                    <td class="align-middle text-center text-sm">{{$komulatif[$i]}}</td>
                                    <td class="align-middle text-center text-sm">{{$interval[$i][array_key_first($interval[$i])]}} - {{$interval[$i][array_key_last($interval[$i])]}}</td>
                                    <td class="align-middle text-center text-sm">{{$random[$i]}}</td>
                                    <td class="align-middle text-center text-sm">{{$peramalan[$i]}}</td>
                                </tr>
                                @endfor
                                <tr>
                                    <td class="align-middle text-center text-sm">
                                        Total
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        {{ $total['stunting'] }}
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        {{ $total['probabilitas'] }}
                                    </td>
                                    <td colspan="3" class="align-middle text-center text-sm">
                                        
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        {{ $total['peramalan'] }}
                                    </td>

                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
