@extends('layouts.app')

@section('template_title')
    {!! trans('ordersmanagement.editing-order', ['fio' => $order->fio]) !!}
@endsection

<link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.5.7/flatpickr.min.css" rel="stylesheet">

@section('template_fastload_css')
	.control-label{
		font-weight: 700;
	}
	.hidden {
		display: none !important;
	}	

	.hidden_vl {
		display: none !important;
	}	
	
	.hidden_pr {
		display: none !important;
	}	
	
	#p-caption-hide {
		display: none;
	}	
	#pr-caption-hide {
		display: none;
	}		
	
	#address-caption-hide {
		display: none;
	}	
	
	.hidden-address {
		display: none;
	}		
	
	.hidden-area {
		display: none;
	}		
	.item div {
		display: none;
	}
	.item input:first-of-type:checked ~ div:first-of-type  {
		display: block;
	}
	.item input:last-of-type:checked ~ div:last-of-type  {
		display: block;
	}	
	h5 {
		margin: 0;
	}	
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
				<div class="alert alert-danger alert-dismissible fade show d-none" role="alert">
					<strong>Обновление!</strong> Поле «Время регистрации» было удалено из формы бронирования. Если пассажиру необходимо больше чем -2 часа, пожалуйста, укажите в дополнительной информации.
					<button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="font-weight-light" aria-hidden="true">×</span></button>
				</div>
                <div class="card">
                    <div class="card-header">
                        <h5>
                            {!! trans('ordersmanagement.editing-order', ['id' => $order->id]) !!}
                            <div class="pull-right">
                                <a href="{{ route('orders') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('ordersmanagement.tooltips.back-orders') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('ordersmanagement.buttons.back-to-orders') !!}
                                </a>
                                <a href="{{ url('/orders/' . $order->id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('ordersmanagement.tooltips.back-orders') }}">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                    {!! trans('ordersmanagement.buttons.back-to-order') !!}
                                </a>
                            </div>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($order->type == 'vl')
							@include('ordersmanagement.partials.edit-form-vl')
                        @elseif($order->type == 'pr')
                            @include('ordersmanagement.partials.edit-form-pr')
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-save')
    @include('modals.modal-delete')


@endsection

@section('footer_scripts')
	@include('scripts.delete-modal-script')
	@include('scripts.save-modal-script')
	@include('scripts.check-changed')

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{asset('js/flatpickr.min.js')}}"></script>
	<script src="https://npmcdn.com/flatpickr/dist/l10n/ru.js"></script>

	<script>
        $(function () {
			var airportvlSelect = $('.airportvl-select');
			var airportprSelect = $('.airportpr-select');
			var statusPay_vl = $('.statusPay_vl');
			var statusPay_pr = $('.statusPay_pr');	
			var childrenvlSelect = $('.childrenvl-select');
			var childrenprSelect = $('.childrenpr-select');			

            airportvlSelect.change(function () {
                var optionSelected = $("option:selected", this);
                $('.airportvl-info').removeClass('hidden').addClass('hidden');
                if (optionSelected.hasClass('borispol')) {
                    $('#terminalvl').removeClass('hidden');
                } else if (optionSelected.hasClass('zhulyany')) {
                    $('#terminalvl').addClass('hidden');
                }
            });			
			
            airportprSelect.change(function () {
                var optionSelected = $("option:selected", this);
                $('.airportpr-info').removeClass('hidden').addClass('hidden');
                if (optionSelected.hasClass('borispol')) {
                    $('#terminalpr').removeClass('hidden');
                } else if (optionSelected.hasClass('zhulyany')) {
                    $('#terminalpr').addClass('hidden');
                }
            });		

            statusPay_vl.change(function () {
                if ($(this).val() === 'paid') {
                    $('#else-statusPay_vl').removeClass('hidden_vl');
                } else {
                    $('#else-statusPay_vl').addClass('hidden_vl');
                }
            });		

            statusPay_pr.change(function () {
                if ($(this).val() === 'paid') {
                    $('#else-statusPay_pr').removeClass('hidden_pr');
                } else {
                    $('#else-statusPay_pr').addClass('hidden_pr');
                }
            });		

            childrenvlSelect.change(function () {
                var optionSelected = $("option:selected", this);
                $('.childrenvl-info').removeClass('hidden').addClass('hidden');
                if (optionSelected.hasClass('children_yes')) {
                    $('#childrenvl').removeClass('hidden');
                } else if (optionSelected.hasClass('children_no')) {
                    $('#childrenvl').addClass('hidden');
                }
            });	

            childrenprSelect.change(function () {
                var optionSelected = $("option:selected", this);
                $('.childrenpr-info').removeClass('hidden').addClass('hidden');
                if (optionSelected.hasClass('children_yes')) {
                    $('#childrenpr').removeClass('hidden');
                } else if (optionSelected.hasClass('children_no')) {
                    $('#childrenpr').addClass('hidden');
                }
            });				

        });
    </script>
	
    <script>
		$(function() {
			$("#p-caption-hide").click(function() {
				$(".hidden-area").css("display", "none");
				$("#p-caption-hide").css("display", "none");
				$("#p-caption-display").css("display", "block");
			});

			$("#p-caption-display").click(function() {
				$(".hidden-area").css("display", "flex");
				$("#p-caption-hide").css("display", "block");
				$("#p-caption-display").css("display", "none");
			});
			
			$("#pr-caption-hide").click(function() {
				$(".hidden-area").css("display", "none");
				$("#pr-caption-hide").css("display", "none");
				$("#pr-caption-display").css("display", "block");
			});

			$("#pr-caption-display").click(function() {
				$(".hidden-area").css("display", "flex");
				$("#pr-caption-hide").css("display", "block");
				$("#pr-caption-display").css("display", "none");
			});			
			
			$("#address-caption-hide").click(function() {
				$(".hidden-address").css("display", "none");
				$("#address-caption-hide").css("display", "none");
				$("#address-caption-display").css("display", "block");
			});

			$("#address-caption-display").click(function() {
				$(".hidden-address").css("display", "flex");
				$("#address-caption-hide").css("display", "block");
				$("#address-caption-display").css("display", "none");
			});			
			
		});
    </script>
	
	<script>
		flatpickr("#date", {
			locale: "ru",
			dateFormat: "Y-m-d",
		});

		flatpickr("#time", {
			locale: "ru",
			enableTime: true,
			dateFormat: "H:i",
			time_24hr: true,
			noCalendar: true,
		});


		var terminals = {
			"Б": ["D", "F"]
			//"Ж": ["A", "B", "D"]
		};

		$('#airport_ukraine').change(function(){
			$('#terminal').html('');

			$.each(terminals[this.value], function(k, v) {
				$('#terminal').prepend('<option value="'+v+'">' + v +'</optoin>')
			})
		})

		$('#airport_ukraine2').change(function(){
			$('#terminal2').html('');

			$.each(terminals[this.value], function(k, v) {
				$('#terminal2').prepend('<option value="'+v+'">' + v +'</optoin>')
			})
		})

		var vlCalc = {
			selectEl: '#airport_ukraine',
			ticketsEl: '#vilet #tickets',
			childTicketsEl: '#vilet #ticket_child',
			resultEl: '#calculated_value_vl',
			suburbEl: '#option_suburb',
			transferEl: '#vilet #transfer',
			transferTypeEl: '#transfer_type_auto',

			bonusEl: {
				personal: '#cardpersonal_vl',
				gold: '#cardgold_vl',
			},

			data: {
				calculatedValue: null,
				elements: {
					select: '',
					tickets: 0,
					childTickets: 0,
					suburb: false,
					transfer: '',
					@if(!$order->transfer_type_auto)
						transferType: null,
					@else
						transferType: '{!! $order->transfer_type_auto !!}',
					@endif
					bonus: {
						personal: false,
						gold: false,
					}
				},
				coefs: {
					B: {
						adult: 300,
						child: 270,
					},
					ZH: {
						adult: 350,
						child: 320,
					},
				},
				transferType: {
					B: {
						1: {{ $transferAutoTypes[0] }},
						2: {{ $transferAutoTypes[1] }},
						3: {{ $transferAutoTypes[2] }},
					},
					J: {
						4: {{ $transferAutoTypes[3] }},
						5: {{ $transferAutoTypes[4] }},
						6: {{ $transferAutoTypes[5] }}
					}
				},
				transferTypeHumans: {
					B: {
						1: 4,
						2: 4,
						3: 8,
					},
					J: {
						4: 4,
						5: 4,
						6: 8,
					},
				},
				trans: {
					transferType: {
						1: '{!! trans('forms.create_order_label_transfer_type_auto_1') !!}',
						2: '{!! trans('forms.create_order_label_transfer_type_auto_2') !!}',
						3: '{!! trans('forms.create_order_label_transfer_type_auto_3') !!}',
						4: '{!! trans('forms.create_order_label_transfer_type_auto_4') !!}',
						5: '{!! trans('forms.create_order_label_transfer_type_auto_5') !!}',
						6: '{!! trans('forms.create_order_label_transfer_type_auto_6') !!}'
					}
				},
			},

			elements: {
				select: null,
				tickets: null,
				childTickets: null,
				result: null,
				suburb: null,
				transfer: null,
				transferType: null,
				bonus: {
					personal: null,
					gold: null,
				}
			},

			init: function () {
				this.elements.select = $(this.selectEl);
				this.elements.tickets = $(this.ticketsEl);
				this.elements.childTickets = $(this.childTicketsEl);
				this.elements.result = $(this.resultEl);
				this.elements.suburb = $(this.suburbEl);
				this.elements.transfer = $(this.transferEl);
				this.elements.transferType = $(this.transferTypeEl);
				this.elements.bonus.personal = $(this.bonusEl.personal);
				this.elements.bonus.gold = $(this.bonusEl.gold);

				this.data.elements.tickets = +this.elements.tickets.val();

				this.initHandlers();

				this.calcValue();
				this.renderResult();
				this.renderTransfer();
			},

			initHandlers: function () {
				var self = this;

				this.elements.select.change(function (event) {
					this.data.elements.select = event.target.value;

					this.calcValue();
					self.renderTransfer();
				}.bind(this));

				this.elements.tickets.on('change', function (event) {
					this.data.elements.tickets = +event.target.value;

					this.calcValue();
				}.bind(this));

				this.elements.childTickets.change(function (event) {
					this.data.elements.childTickets = +event.target.value;

					this.calcValue();
				}.bind(this));

				this.elements.suburb.change(function () {
					self.data.elements.suburb = $(this).is(":checked");

					self.calcValue();
				});

				this.elements.transfer.change(function () {
					self.data.elements.transfer = event.target.value;

					self.renderTransfer();
					this.calcValue();
				});

				this.elements.transferType.change(function (event) {
					self.data.elements.transferType = event.target.value;

					self.calcValue();
				});

				this.data.elements.select = this.elements.select.val();
				this.data.elements.tickets = +this.elements.tickets.val();
				this.data.elements.childTickets = +this.elements.childTickets.val();
				self.data.elements.suburb = this.elements.suburb.is(":checked");
				self.data.elements.transfer = this.elements.transfer.val();
			},

			calcValue: function () {
				if (this.data.elements.select) {
                    var selectVal = '',
                        result = 0,
                        humansCount = 0;

                    if (this.data.elements.select === 'Б') selectVal = 'B';
                    if (this.data.elements.select === 'Ж') selectVal = 'ZH';

					if (this.data.elements.tickets && this.data.elements.tickets >= 0) {
						if (this.data.elements.transfer === 'group')
							result += this.data.elements.tickets *
									this.data.coefs[selectVal].adult;
						humansCount += this.data.elements.tickets;
					}

					if (this.data.elements.childTickets && this.data.elements.childTickets >= 0) {
						if (this.data.elements.transfer === 'group')
							result += this.data.elements.childTickets *
									this.data.coefs[selectVal].child;
						humansCount += this.data.elements.childTickets;
					}

                    if (this.data.elements.suburb)
                        result += 100;

                    if (this.data.elements.select === 'Ж') selectVal = 'J';

                    var prices = this.data.transferType[selectVal],
                        transferHumansCount = this.data.transferTypeHumans[selectVal];

                    if (this.data.elements.transferType && prices.hasOwnProperty(this.data.elements.transferType)) {
						var humanGroups = Math.ceil(humansCount / transferHumansCount[this.data.elements.transferType]);
						result += prices[+this.data.elements.transferType] * humanGroups;
					}

					this.data.calculatedValue = result;
				}

				if (this.data.elements.tickets + this.data.elements.childTickets !== 1) {
					this.elements.bonus.personal.prop('checked', false);
					this.elements.bonus.gold.prop('checked', false);

					this.elements.bonus.personal.parent().addClass('disabled');
					this.elements.bonus.gold.parent().addClass('disabled');
				} else {
					this.elements.bonus.personal.parent().removeClass('disabled');
					this.elements.bonus.gold.parent().removeClass('disabled');
				}

				this.renderResult();
			},

			renderTransfer: function () {
				if (this.data.elements.transfer === 'individual') {
					this.renderTransferType('block');
				} else {
					this.renderTransferType();
				}
			},

			renderTransferType: function (displayVal = 'none') {
				this.elements.transferType
						.parents('.form-group')
						.css('display', displayVal);
				var selectVal = '';


				if (displayVal === 'block') {
					if (this.data.elements.select === 'Б') selectVal = 'B';
					if (this.data.elements.select === 'Ж') selectVal = 'J';


					var prices = this.data.transferType[selectVal],
							elements = '<option value>Выберите ценовую категорию</option>';

					for (var key in prices) {
						elements += '<option value="' + key + '" ' + (this.data.elements.transferType == key ? 'selected' : '')
								+ '>' + prices[key] + ' - ' + this.data.trans.transferType[key] + '</option>';
					}

					this.elements.transferType.empty();
					this.elements.transferType.append(elements);

				}
			},

			renderResult: function () {
				if (this.data.calculatedValue !== null &&
						this.data.calculatedValue >= 0)
					this.elements.result.text(this.data.calculatedValue);
				else
					this.elements.result.text();
			},
		};

		@if($order->type == 'vl')
			vlCalc.init();
		@endif

		var prCalc = {
			selectEl: '#airport_ukraine',
			ticketsEl: '#prilet #tickets',
			childTicketsEl: '#prilet #ticket_child',
			resultEl: '#calculated_value_pr',
			nameplateEl: '#option_nameplate_pr',
			transferEl: '#prilet #transfer',
			suburbEl: '#option_suburb_pr',
            transferTypeEl: '#transfer_type_auto',

			bonusEl: {
				personal: '#cardpersonal_pr',
				gold: '#cardgold_pr',
				discounthalf: '#discounthalf_pr',
			},

			data: {
				calculatedValue: null,
				elements: {
					select: '',
					tickets: 0,
					childTickets: 0,
					nameplate: false,
					transfer: '',
					suburb: false,
					@if(!$order->transfer_type_auto)
						transferType: null,
					@else
						transferType: '{!! $order->transfer_type_auto !!}',
					@endif
					bonus: {
						personal: false,
						gold: false,
						discounthalf: false,
					}
				},
				transferType: {
					B: {
						1: {{ $transferAutoTypes[0] }},
						2: {{ $transferAutoTypes[1] }},
						3: {{ $transferAutoTypes[2] }},
					},
					J: {
						4: {{ $transferAutoTypes[3] }},
						5: {{ $transferAutoTypes[4] }},
						6: {{ $transferAutoTypes[5] }}
					}
				},
				transferTypeHumans: {
					B: {
						1: 4,
						2: 4,
						3: 8,
					},
					J: {
						4: 4,
						5: 4,
						6: 8,
					},
				},
				trans: {
					transferType: {
						1: '{!! trans('forms.create_order_label_transfer_type_auto_1') !!}',
						2: '{!! trans('forms.create_order_label_transfer_type_auto_2') !!}',
						3: '{!! trans('forms.create_order_label_transfer_type_auto_3') !!}',
						4: '{!! trans('forms.create_order_label_transfer_type_auto_4') !!}',
						5: '{!! trans('forms.create_order_label_transfer_type_auto_5') !!}',
						6: '{!! trans('forms.create_order_label_transfer_type_auto_6') !!}'
					}
				},
				coefs: {
					B: {
						adult: 300,
						child: 270,
					},
					ZH: {
						adult: 350,
						child: 320,
					},
				},
			},

			elements: {
				select: null,
				tickets: null,
				childTickets: null,
				result: null,
				nameplate: null,
				transfer: null,
				suburb: null,
                transferType: null,
				bonus: {
					personal: null,
					gold: null,
					discounthalf: null,
				}
			},

			init: function () {
				this.elements.select = $(this.selectEl);
				this.elements.tickets = $(this.ticketsEl);
				this.elements.childTickets = $(this.childTicketsEl);
				this.elements.result = $(this.resultEl);
				this.elements.nameplate = $(this.nameplateEl);
				this.elements.transfer = $(this.transferEl);
				this.elements.suburb = $(this.suburbEl);
				this.elements.transferType = $(this.transferTypeEl);
				this.elements.bonus.personal = $(this.bonusEl.personal);
				this.elements.bonus.gold = $(this.bonusEl.gold);
				this.elements.bonus.discounthalf = $(this.bonusEl.discounthalf);

				this.data.elements.tickets = +this.elements.tickets.val();

				this.initHandlers();

				this.calcValue();
				this.renderResult();
			},

			initHandlers: function () {
				var self = this;

				this.elements.select.change(function (event) {
					self.data.elements.select = event.target.value;

					self.calcValue();
					self.renderTransfer();
				});

				this.elements.tickets.on('change', function (event) {
					self.data.elements.tickets = +event.target.value;

					self.calcValue();
				});

				this.elements.childTickets.change(function (event) {
					self.data.elements.childTickets = +event.target.value;

					self.calcValue();
				});

				this.elements.nameplate.change(function () {
					self.data.elements.nameplate = $(this).is(":checked");

					self.calcValue();
				});

				this.elements.suburb.change(function () {
					self.data.elements.suburb = $(this).is(":checked");

					self.calcValue();
				});

				this.elements.transfer.change(function (event) {
					self.data.elements.transfer = event.target.value;

					self.renderTransfer();
					this.calcValue();
				});

				this.elements.transferType.change(function (event) {
					self.data.elements.transferType = event.target.value;

					self.calcValue();
				});

				this.data.elements.select = this.elements.select.val();
				this.data.elements.tickets = +this.elements.tickets.val();
				this.data.elements.childTickets = +this.elements.childTickets.val();
				this.data.elements.suburb = this.elements.suburb.is(":checked");
				this.data.elements.transfer = this.elements.transfer.val();

				this.renderTransfer();
			},

			calcValue: function () {
				if (this.data.elements.select) {
					var selectVal = '',
							result = 0,
							humansCount = 0;

					if (this.data.elements.select === 'Б') selectVal = 'B';
					if (this.data.elements.select === 'Ж') selectVal = 'ZH';

					if (this.data.elements.tickets && this.data.elements.tickets >= 0) {
						if (this.data.elements.transfer === 'group')
							result += this.data.elements.tickets *
									this.data.coefs[selectVal].adult;
						humansCount += this.data.elements.tickets;
					}

					if (this.data.elements.childTickets && this.data.elements.childTickets >= 0) {
						if (this.data.elements.transfer === 'group')
							result += this.data.elements.childTickets *
									this.data.coefs[selectVal].child;
						humansCount += this.data.elements.childTickets;
					}

					if (this.data.elements.nameplate)
						result += 150;

					if (this.data.elements.suburb)
						result += 100;

					if (this.data.elements.select === 'Ж') selectVal = 'J';

					var prices = this.data.transferType[selectVal],
							transferHumansCount = this.data.transferTypeHumans[selectVal];

					if (this.data.elements.transferType && prices.hasOwnProperty(this.data.elements.transferType)) {
						var humanGroups = Math.ceil(humansCount / transferHumansCount[this.data.elements.transferType]);
						result += prices[+this.data.elements.transferType] * humanGroups;
					}

					this.data.calculatedValue = result;
				}

				if (this.data.elements.tickets + this.data.elements.childTickets !== 1) {
					this.elements.bonus.personal.prop('checked', false);
					this.elements.bonus.gold.prop('checked', false);
					this.elements.bonus.discounthalf.prop('checked', false);

					this.elements.bonus.personal.parent().addClass('disabled');
					this.elements.bonus.gold.parent().addClass('disabled');
					this.elements.bonus.discounthalf.parent().addClass('disabled');
				} else {
					this.elements.bonus.personal.parent().removeClass('disabled');
					this.elements.bonus.gold.parent().removeClass('disabled');
					this.elements.bonus.discounthalf.parent().removeClass('disabled');
				}

				this.renderResult();
			},

			renderTransfer: function () {
				if (this.data.elements.transfer === 'group') {
					this.elements.nameplate.prop('checked', false);
					this.elements.nameplate.attr('disabled', 'disabled');
					this.renderTransferType();
				} else if (this.data.elements.transfer === 'individual') {
                    this.renderTransferType('block');

                    this.elements.nameplate.removeAttr('disabled');
                } else {
					this.renderTransferType();
                    this.elements.nameplate.removeAttr('disabled');
                }
			},

			renderTransferType: function (displayVal = 'none') {
				this.elements.transferType
						.parents('.form-group')
						.css('display', displayVal);
				var selectVal = '';


				if (displayVal === 'block') {
					if (this.data.elements.select === 'Б') selectVal = 'B';
					if (this.data.elements.select === 'Ж') selectVal = 'J';


					var prices = this.data.transferType[selectVal],
						elements = '<option value>Выберите ценовую категорию</option>';

					for (var key in prices) {
						elements += '<option value="' + key + '" ' + (this.data.elements.transferType == key ? 'selected' : '')
								+ '>' + prices[key] + ' - ' + this.data.trans.transferType[key] + '</option>';
					}

					this.elements.transferType.empty();
					this.elements.transferType.append(elements);

				}
			},

			renderResult: function () {
				if (this.data.calculatedValue !== null &&
						this.data.calculatedValue >= 0)
					this.elements.result.text(this.data.calculatedValue);
				else
					this.elements.result.text();
			},
		};


		@if($order->type == 'pr')
			prCalc.init();
		@endif

	</script>
@endsection


