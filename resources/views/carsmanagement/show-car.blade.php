@extends('layouts.app')

@section('template_title')
    {{ trans('cars.showHeadTitle') . ' ' . $car->side_number }}
@endsection

@section('template_fastload_css')

    .list-group-responsive span:not(.badge) {
        display: block;
        overflow-y: auto;
    }
    .list-group-responsive span.badge {
        margin-left: 7.25em;
    }
	
	.cars-info {font-size: 28px;}

    .car-details-list strong {
        width: 5.5em;
        display: inline-block;
        position: absolute;
    }

    .car-details-list span {
        margin-left: 5.5em;
    }
	
	.side_number {
		position: absolute;
		top: -10px;
		left: -10px;
		font-size: 23px;
	}
	.side_number .badge {
		box-shadow: 0 3px 10px rgba(0, 0, 0, 0.25);
		padding: 0;
		width: 35px;
		height: 35px;
		text-align: center;
		line-height: 35px;
	}
	.costs-sum {
		position: absolute;
		bottom: -10px;
		width: 100%;
		text-align: center;
		font-size: 18px;
	}

@endsection

@php
    $carStatus = [
        'name'  => trans('cars.statusDisabled'),
        'class' => 'danger'
    ];
    if($car->status == 1) {
        $carStatus = [
            'name'  => trans('cars.statusEnabled'),
            'class' => 'success'
        ];
    }
@endphp

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-xl-6 offset-xl-3 text-center">
			<h1 class="mb-4">Информация об автомобиле</h1>
			<div class="cars-info">
				<div class="position-absolute" style="left: -30px;top: 35%;">
					@if($car->side_number != null)
						<div class="cost-summ" style="top: 40px;">
							<span class="badge badge-success">{{ $car->side_number }}</span>
						</div>
					@endif	
					@if($car->mileage != null)
						<div class="mileage-buy" style="top: 80px;">
							<span class="badge badge-success">Пробег до: {{ $car->mileage }} км</span>
						</div>
					@endif
					@if($car->side_number != null)
						<div class="mileage" style="top: 40px;">
							<span class="badge badge-success">Сейчас: {{ $car->getLastCostMileage() }} км</span>
						</div>
					@endif				
				</div>
				<img src="{{ $car->getImage()  }}" alt="" class="img-fluid w-75">
				<div class="position-absolute" style="right: 55px;top: 50%;">

					@if($car->registration_number != null)
						<div class="cost-summ" style="top: 80px;">
							<span class="badge badge-success">{{ $car->registration_number }}</span>
						</div>
					@endif				
				</div>	
				<div class="position-absolute" style="right: 42%;bottom: -5%;">
					<div class="cost-summ" style="top: 80px;">
						<div class="badge badge-success">
							<span class="small">Куплено за</span>
							<br>
							{{ $car->purchase_price }} грн.
						</div>
					</div>
				</div>
			</div>	
			<div class="d-none">
				<h4><span class="badge">{{ count($carCosts) }}</span> {{ trans('cars.showCosts') }}</h4>	
				<strong>{{ trans('cars.showStatus') }}</strong>
				<span class="badge badge-{{ $carStatus['class'] }}">
					{{ $carStatus['name'] }}
				</span>
			</div>
		</div>
	</div>
    <div class="row mt-5 d-flex justify-content-center">
		@foreach($categorycosts['default'] as $aCategoryCost)
			@php
				$costsByCarCategory = $aCategoryCost->costsByCar($car);
				$carCategoryCosts = $costsByCarCategory->costs->count();

				if($carCategoryCosts === 1) {
					$carCountClass = 'info';
				} elseif($carCategoryCosts >= 2) {
					$carCountClass = 'warning';
				} elseif($carCategoryCosts === 5) {
					$carCountClass = 'success';
				} elseif($carCategoryCosts === 10) {
					$carCountClass = 'danger';
				}				
			@endphp
			<div class="col-md-2 mb-3">
				<div class="card">
					<a href="{{ route('cars.costs_by_category', ['carId' => $car->registration_number, 'categorycostId' => $aCategoryCost->id]) }}">
						<div class="sost-summ" style="position: absolute;top: -10px;left: -10px;width: 100%;text-align: left;">
							<span class="badge badge-success">{{ $carCategoryCosts }}</span>
						</div>
						<div class="card-body text-center">
							<img src="{{ $aCategoryCost->img }}" alt="" class="img-fluid w-50">
						</div>
						<div class="price-summ" style="position: absolute;bottom: -10px;width: 100%;text-align: center;">
							<span class="badge badge-success">Cумма: <b>{{ $costsByCarCategory->sum }} грн.</b></span>
						</div>
					</a>

				</div>
				<h6 class="text-center mt-3"><b>{{ $aCategoryCost->name }}</b></h6>

			</div>
		@endforeach
    </div>

	<h2 class="text-center mt-5 mb-5">Обслуживание и ремонт</h2>
	<div class="row d-flex justify-content-center">
		@foreach($categorycosts['support_repair'] as $aCategoryCost)
			@php
				$costsByCarCategory = $aCategoryCost->costsByCar($car);
				$carCategoryCosts = $costsByCarCategory->costs->count();

				if($carCategoryCosts === 1) {
					$carCountClass = 'info';
				} elseif($carCategoryCosts >= 2) {
					$carCountClass = 'warning';
				} elseif($carCategoryCosts === 5) {
					$carCountClass = 'success';
				} elseif($carCategoryCosts === 10) {
					$carCountClass = 'danger';
				}
			@endphp
			<div class="col-md-2 mb-3">
				<div class="card">
					<a href="{{ route('cars.costs_by_category', ['carId' => $car->registration_number, 'categorycostId' => $aCategoryCost->id]) }}">
					<div class="sost-summ" style="position: absolute;top: -10px;left: -10px;width: 100%;text-align: left;">
						<span class="badge badge-success">{{ $carCategoryCosts }}</span>
					</div>
					<div class="card-body text-center">
						<img src="{{ $aCategoryCost->img }}" alt="" class="img-fluid w-50">
					</div>
					<div class="price-summ" style="position: absolute;bottom: -10px;width: 100%;text-align: center;">
						<span class="badge badge-success">Cумма: <b>{{ $costsByCarCategory->sum }} грн.</b></span>
					</div>
					</a>
				</div>
				<h6 class="text-center mt-3"><b>{{ $aCategoryCost->name }}</b></h6>

			</div>
		@endforeach
	</div>

	<h2 class="text-center mt-5 mb-5">Прочее</h2>
	<div class="row d-flex justify-content-center">
		@foreach($categorycosts['others'] as $aCategoryCost)
			@php
				$costsByCarCategory = $aCategoryCost->costsByCar($car);
				$carCategoryCosts = $costsByCarCategory->costs->count();

				if($carCategoryCosts === 1) {
					$carCountClass = 'info';
				} elseif($carCategoryCosts >= 2) {
					$carCountClass = 'warning';
				} elseif($carCategoryCosts === 5) {
					$carCountClass = 'success';
				} elseif($carCategoryCosts === 10) {
					$carCountClass = 'danger';
				}
			@endphp
			<div class="col-md-2 mb-3">
				<div class="card">
					<a href="{{ route('cars.costs_by_category', ['carId' => $car->registration_number, 'categorycostId' => $aCategoryCost->id]) }}">
					<div class="sost-summ" style="position: absolute;top: -10px;left: -10px;width: 100%;text-align: left;">
						<span class="badge badge-success">{{ $carCategoryCosts }}</span>
					</div>
					<div class="card-body text-center">
						<img src="{{ $aCategoryCost->img }}" alt="" class="img-fluid w-50">
					</div>
					<div class="price-summ" style="position: absolute;bottom: -10px;width: 100%;text-align: center;">
						<span class="badge badge-success">Cумма: <b>{{ $costsByCarCategory->sum }} грн.</b></span>
					</div>
					</a>
				</div>
				<h6 class="text-center mt-3"><b>{{ $aCategoryCost->name }}</b></h6>

			</div>
		@endforeach
	</div>

	<div class="row pt-5">
		<div class="col-sm-6 mb-2">
			<a href="/cars/{{$car->registration_number}}/edit" class="btn btn-small btn-info btn-block">
				<i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit<span class="hidden-sm"> this</span><span class="hidden-sm"> car</span>
			</a>
		</div>
		{!! Form::open(array('url' => 'cars/' . $car->id, 'class' => 'col-sm-6 mb-2')) !!}
			{!! Form::hidden('_method', 'DELETE') !!}
			{!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> Delete<span class="hidden-sm"> this</span><span class="hidden-sm"> car</span>', array('class' => 'btn btn-danger btn-block btn-flat','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('cars.confirmDeleteHdr'), 'data-message' => trans('cars.confirmDelete'))) !!}
		{!! Form::close() !!}
	</div>
</div>

@include('modals.modal-delete')

@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
    @include('scripts.tooltips')

@endsection
