<div class="form-group"><div class="col-sm-12">{!! Form::label('fixed_line_opportunity_status_id', 'Blown Status', ['class' => 'control-label']) !!}{!! Form::select('fixed_line_opportunity_status_id', FormPopulator::fixedLineBlownStatuses(), null, ['class' => 'form-control', 'placeholder' => 'Please Select', 'required' => 'required']) !!}</div></div>