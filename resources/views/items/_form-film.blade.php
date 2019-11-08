      {{-- FilmItem fields --}}
       <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_element')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[film_element]', 'Element', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[film_element]', null, array('id' => 'film-element', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Negative')) !!}
            @if ($errors->has('subclass.film_element'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_element') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_base')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[film_base]', 'Base', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[film_base]', null, array('id' => 'film-base', 'class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Polyester')) !!}
            @if ($errors->has('subclass.film_base'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_base') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_color')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[film_color]', 'Color', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[film_color]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. B/W')) !!}
            @if ($errors->has('subclass.film_color'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_color') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[sound_type]', 'Sound Type', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            @if (!$item->batch() || $item->subclass->sound_type !== '<mixed>')
              {!! Form::select('subclass[sound_type]',
                array('' => 'Select a type', 'Magnetic' => 'Magnetic', 'Optical' => 'Optical', 'Magnetic; Optical' => 'Magnetic; Optical', 'Silent' => 'Silent'), $item->subclass == null ? null : $item->subclass->sound_type, array('class' => 'form-control form-control-sm')) !!}
            @else
              {!! Form::select('subclass[sound_type]',
                array('' => 'Select a type', '<mixed>' => '<mixed>', 'Magnetic' => 'Magnetic', 'Optical' => 'Optical', 'Magnetic; Optical' => 'Magnetic; Optical', 'Silent' => 'Silent'), $item->subclass == null ? null : $item->subclass->sound_type, array('class' => 'form-control form-control-sm')) !!}
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.length_in_feet')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[length_in_feet]', 'Length in Feet', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[length_in_feet]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. 400')) !!}
            @if ($errors->has('subclass.length_in_feet'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.length_in_feet') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_stock')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[film_stock]', 'Film Stock', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[film_stock]', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.film_stock'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_stock') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.edge_code')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[edge_code]', 'Edge Code', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[edge_code]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. Triangle, Triangle')) !!}
            @if ($errors->has('subclass.edge_code'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.edge_code') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.shrinkage_percent')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[shrinkage_percent]', 'Shrinkage Percent', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[shrinkage_percent]', null, array('class' => 'form-control form-control-sm', 'placeholder' => 'e.g. .08')) !!}
            @if ($errors->has('subclass.shrinkage_percent'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.shrinkage_percent') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.can_number')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[can_number]', 'Can Number', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[can_number]', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.can_number'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.can_number') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.condition')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[condition]', 'Condition', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::text('subclass[condition]', null, array('class' => 'form-control form-control-sm')) !!}
            @if ($errors->has('subclass.condition'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.condition') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group @if ($errors->has('subclass.film_content_description')) has-danger @endif">
          <div class="col-xs-4 detail-label">
            {!! Form::label('subclass[film_content_description]', 'Content Description', array('class' => 'form-control-label')) !!}
          </div>
          <div class="col-xs-7 detail-value">
            {!! Form::textarea('subclass[film_content_description]', null, array('class' => 'form-control form-control-sm', 'rows' => 3)) !!}
            @if ($errors->has('subclass.film_content_description'))
              <div class="form-control-label"><small>{!! $errors->first('subclass.film_content_description') !!}</small></div>
            @endif
          </div>
        </div>
      </div>
      {{-- End FilmItem fields --}}