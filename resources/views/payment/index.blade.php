@extends('template.master')
@section('title', __('Payment'))
@section('content')

    <div class="card shadow-sm border">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('Room') }}</th>
                        <th scope="col">{{ __('Paid Off') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('At') }}</th>
                        <th scope="col">{{ __('Served By') }}</th>
                        <th scope="col">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <th scope="row">{{ ($payments->currentpage() - 1) * $payments->perpage() + $loop->index + 1 }}
                            </th>
                            <td>{{ $payment->transaction->room->number }}</td>
                            <td>{{ Helper::convertToRupiah($payment->price) }}</td>
                            <td>{{ $payment->status }}</td>
                            <td>{{ Helper::dateFormatTime($payment->created_at) }}</td>
                            <td>{{ $payment->user->name }}</td>
                            <td> <a href="{{ route('payment.invoice', $payment->id) }}">{{ __('Invoice') }}</a> </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="6">{{ __('Theres no payment found on database') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
