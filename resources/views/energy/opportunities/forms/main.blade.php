<div class="form-group">
    {!! Form::label('suppliers', 'Current Supplier(s)', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::select('suppliers[]', $suppliers, isset($opportunity) && $opportunity->suppliers ? $opportunity->suppliers->pluck('id')->toArray() : null, ['class' => 'form-control select2', 'multiple']) !!}

        {!! $errors->first('suppliers', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('monthly_spend', 'Typical Monthly Spend', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::number('monthly_spend', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'step' => 0.1]) !!}

        {!! $errors->first('monthly_spend', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('number_of_sites', 'Number of Sites', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::number('number_of_sites', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off', 'step' => 1]) !!}

        {!! $errors->first('number_of_sites', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('looking_for_prices', 'Currently looking for prices?', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::text('looking_for_prices', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

        {!! $errors->first('looking_for_prices', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('direct_or_broker', 'Direct or Broker', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::text('direct_or_broker', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

        {!! $errors->first('direct_or_broker', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('typical_contact_length', 'Typical contract length', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::text('typical_contact_length', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

        {!! $errors->first('typical_contact_length', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('supplier_to_avoid', 'Suppliers to avoid', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::text('supplier_to_avoid', null, ['class' => 'form-control', 'required', 'autocomplete' => 'off']) !!}

        {!! $errors->first('supplier_to_avoid', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
        <label>
            {!! Form::checkbox('energy_procurement', 1, null,  ['id' => 'name']) !!}
            Energy Procurement <br>
            Customer is coming to the end of their current contract, or is already out of contract (and we can sell a new contract)
        </label>

        {!! $errors->first('energy_procurement', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
        <label>
            {!! Form::checkbox('price_comparison', 1, null,  ['id' => 'name']) !!}
            Price Comparison <br>
            Comparing the customer’s existing contracts and unit rates against the current market prices
        </label>

        {!! $errors->first('price_comparison', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
        <label>
            {!! Form::checkbox('kva_mapping_report', 1, null,  ['id' => 'name']) !!}
            KVA Mapping Report <br>
            A 24 month mapping report will be carried out to check the capacity of the electricity meter
        </label>

        {!! $errors->first('kva_mapping_report', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
        <label>
            {!! Form::checkbox('contract_validation', 1, null,  ['id' => 'name']) !!}
            Contract Validation <br>
            For customers with any discrepancy such as a mis-sold contract or incorrect prices, and any other issues
        </label>

        {!! $errors->first('contract_validation', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    <div class="col-sm-10 col-sm-offset-2">
        <label>
            {!! Form::checkbox('energy_audit', 1, null,  ['id' => 'name']) !!}
            Energy Audit <br>
            A 24 month mapping report will be carried out to check the capacity of the electricity meter
        </label>

        {!! $errors->first('energy_audit', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>

<div class="form-group-separator"></div>

<div class="form-group">
    {!! Form::label('notes', 'Notes', ['class' => 'col-sm-2 control-label']) !!}

    <div class="col-sm-10">
        {!! Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 5, 'required', 'autocomplete' => 'off']) !!}

        {!! $errors->first('notes', '<p class="help-block text-danger"><i class="fa fa-fw fa-warning"></i> :message</p>') !!}
    </div>
</div>