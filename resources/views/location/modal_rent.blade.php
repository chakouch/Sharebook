<div id="modal_azure_budget_create" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="float-left modal-title">Location d'ouvrage</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>   
            </div>
            <div class="modal-body">
                <form id = "form_azure_create_budget" action="{{ route('cart.rent', $id) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="date" class="control-label">Période de la location</label>
                        <div >
                            <div id="azure_budget_calendar" style="background: #fff; cursor: pointer; padding: 5px 7px; border: 1px solid #ccc; width: 100%">
                                <i name="date" class="fa fa-calendar input-sm"></i>
                                <span></span>
                            </div>
                        </div>
                        </br>
                        <label class="control-label">Nombre de jours</label>
                        <div >
                            <input id="renting_days" name="days" readonly ></input>
                        </div>
                        </br>
                        <label class="control-label">Coût de la location (€)</label>
                        <div >
                            <input id="renting_cost" name="cost" readonly ></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary btn-sm" form="form_azure_create_budget">Louer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    var calendar_range_start = moment();
    var calendar_range_end = moment();

    function changeCalendarDates(start_date, end_date) {
        $('#azure_budget_calendar span').html(moment().format('DD/MM/YYYY') + ' - ' + end_date.format('DD/MM/YYYY'));
        var days = end_date.diff(moment(), 'days');
        var cost = Math.round((days * 0.5)*10)/10
        $('#renting_cost').val(cost);
        $('#renting_days').val(days);
        calendar_range_start = start_date;
        calendar_range_end = end_date;
    }


    $('#azure_budget_calendar').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minDate: moment(),
        ranges: {
            '1 jour': [moment(), moment().add(1, 'day')],
            '1 semaine': [moment(), moment().add(1, 'week')],
            '2 semaines': [moment(), moment().add(2, 'week')],
            '1 mois': [moment(), moment().add(1, 'month')],
        },
    },function(start, end) {
        changeCalendarDates(start, end);
    });

    changeCalendarDates(calendar_range_start, calendar_range_end);
</script>