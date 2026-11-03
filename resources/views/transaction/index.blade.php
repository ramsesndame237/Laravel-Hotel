@extends('template.master')
@section('title', __('Reservation'))
@section('content')
    <div class="row mt-2 mb-2">
        <div class="col-lg-6 mb-2">
            <div class="d-grid gap-2 d-md-block">
                <span data-bs-toggle="tooltip" data-bs-placement="right" title="{{ __('Add Room Reservation') }}">
                    <button type="button" class="btn btn-sm shadow-sm myBtn border rounded" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                        <i class="fas fa-plus"></i>
                    </button>
                </span>
                <span data-bs-toggle="tooltip" data-bs-placement="right" title="{{ __('Payment History') }}">
                    <a href="{{route('payment.index')}}" class="btn btn-sm shadow-sm myBtn border rounded">
                        <i class="fas fa-history"></i>
                    </a>
                </span>
            </div>
        </div>
        <div class="col-lg-6 mb-2">
            <form class="d-flex" method="GET" action="{{ route('transaction.index') }}">
                <input class="form-control me-2" type="search" placeholder="{{ __('Search by ID') }}" aria-label="{{ __('Search') }}"
                    id="search-user" name="search" value="{{ request()->input('search') }}">
                <button class="btn btn-outline-dark" type="submit">{{ __('Search') }}</button>
            </form>
        </div>
    </div>
    <div class="row my-2 mt-4 ms-1">
        <div class="col-lg-12">
            <h5>{{ __('Active Guests:') }} </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-0">
                <div class="card-body">
                    <div class="table-responsive" style="max-width: calc(100vw - 50px)">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Room') }}</th>
                                    <th>{{ __('Check In') }}</th>
                                    <th>{{ __('Check Out') }}</th>
                                    <th>{{ __('Days Count') }}</th>
                                    <th>{{ __('Total Price') }}</th>
                                    <th>{{ __('Paid Off') }}</th>
                                    <th>{{ __('Debt') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <th>{{ ($transactions->currentpage() - 1) * $transactions->perpage() + $loop->index + 1 }}
                                        </th>
                                        <td>{{ $transaction->id }}</td>
                                        <td>{{ $transaction->customer->name }}</td>
                                        <td>{{ $transaction->room->number }}</td>
                                        <td>{{ Helper::dateFormat($transaction->check_in) }}</td>
                                        <td>{{ Helper::dateFormat($transaction->check_out) }}</td>
                                        <td>{{ $transaction->getDateDifferenceWithPlural($transaction->check_in, $transaction->check_out) }}
                                        </td>
                                        <td>{{ Helper::formatPrice($transaction->getTotalPrice()) }}
                                        </td>
                                        <td>
                                            {{ Helper::formatPrice($transaction->getTotalPayment()) }}
                                        </td>
                                        <td>{{ $transaction->getTotalPrice() - $transaction->getTotalPayment() <= 0 ? '-' : Helper::formatPrice($transaction->getTotalPrice() - $transaction->getTotalPayment()) }}
                                        </td>
                                        <td>
                                            <a class="btn btn-light btn-sm rounded shadow-sm border p-1 m-0 {{$transaction->getTotalPrice() - $transaction->getTotalPayment() <= 0 ? 'disabled' : ''}}"
                                                href="{{ route('transaction.payment.create', ['transaction' => $transaction->id]) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Pay') }}">
                                                <i class="fas fa-money-bill-wave-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15" class="text-center">
                                            {{ __('There\'s no data in this table') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $transactions->onEachSide(2)->links('template.paginationlinks') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-2 mt-4 ms-1">
        <div class="col-lg-12">
            <h5>{{ __('Expired:') }} </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card p-0">
                <div class="card-body">
                    <div class="table-responsive" style="max-width: calc(100vw - 50px)">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Room') }}</th>
                                    <th>{{ __('Check In') }}</th>
                                    <th>{{ __('Check Out') }}</th>
                                    <th>{{ __('Days Count') }}</th>
                                    <th>{{ __('Total Price') }}</th>
                                    <th>{{ __('Paid Off') }}</th>
                                    <th>{{ __('Debt') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactionsExpired as $transaction)
                                <tr>
                                    <th>{{ ($transactions->currentpage() - 1) * $transactions->perpage() + $loop->index + 1 }}
                                    </th>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->customer->name }}</td>
                                    <td>{{ $transaction->room->number }}</td>
                                    <td>{{ Helper::dateFormat($transaction->check_in) }}</td>
                                    <td>{{ Helper::dateFormat($transaction->check_out) }}</td>
                                    <td>{{ $transaction->getDateDifferenceWithPlural($transaction->check_in, $transaction->check_out) }}
                                    </td>
                                    <td>{{ Helper::formatPrice($transaction->getTotalPrice()) }}
                                    </td>
                                    <td>
                                        {{ Helper::formatPrice($transaction->getTotalPayment()) }}
                                    </td>
                                    <td>{{ $transaction->getTotalPrice() - $transaction->getTotalPayment() <= 0 ? '-' : Helper::formatPrice($transaction->getTotalPrice($transaction->room->price, $transaction->check_in, $transaction->check_out) - $transaction->getTotalPayment()) }}
                                    </td>
                                    <td>
                                        <a class="btn btn-light btn-sm rounded shadow-sm border p-1 m-0 {{$transaction->getTotalPrice($transaction->room->price, $transaction->check_in, $transaction->check_out) - $transaction->getTotalPayment() <= 0 ? 'disabled' : ''}}"
                                            href="{{ route('transaction.payment.create', ['transaction' => $transaction->id]) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Pay') }}">
                                            <i class="fas fa-money-bill-wave-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15" class="text-center">
                                        {{ __('There\'s no data in this table') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $transactions->onEachSide(2)->links('template.paginationlinks') }}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('Have any account?') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-sm btn-primary m-1"
                            href="{{ route('transaction.reservation.createIdentity') }}">{{ __('No, create new account!') }}</a>
                        <a class="btn btn-sm btn-success m-1"
                            href="{{ route('transaction.reservation.pickFromCustomer') }}">{{ __('Yes, use their account!') }}</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
