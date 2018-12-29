->join('account_head', 'money_transaction.to_account_head', '=', 'account_head.id')


select sum(amount) from money_transaction where to_account_head in(1,2)


<div class="form-group row" id="bankdetails" style="visibility: hidden;">
                        <label for="payment_mode" class="col-sm-4 col-form-label text-md-right">{{ __('Bank Details') }}</label>

                        <div class="col-md-6">
                          <select name="bank_id" class="form-control{{ $errors->has('bank_id') ? ' is-invalid' : '' }}" id="selectbankdetails">
                            <option value="">--Select--</option>

                            @foreach ($bank_details as $bank)
                                  <option value="{{$bank['id']}}">{{$bank['bank_name']." - ".$bank['account_number']}}</option>
                            @endforeach
                            
                          </select>

                          @if ($errors->has('bank_id'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('bank_id') }}</strong>
                                      </span>
                           @endif
                        </div>
                    </div>









                    
                                      <td><input id="date_from" placeholder="date_from" type="text" class="form-control{{ $errors->has('date_from') ? ' is-invalid' : '' }}" name="date_from" value="{{ old('date_from') }}" ></td>
                                      <td><input id="date_to" type="text" placeholder="date_to"class="form-control{{ $errors->has('date_to') ? ' is-invalid' : '' }}" name="date_to" value="{{ old('date_to') }}" ></td>
                                      <td><select name="blog_tag[]" multiple="multiple">
                                        @foreach ($tags as $tag)
                                          <option {{in_array($tag['id'],old('blog_tag', array()))?'selected='.'"'.'selected'.'"':'' }} value="{{$tag['id']}}">{{$tag['tag_name']}}</option>
                                        @endforeach
                                      </select></td>
                                      




function showDiv() {

    var select = document.getElementById('payment_mode');
    var input = "select.options[select.selectedIndex].value;

    if(input == 2) {

    document.getElementById('bankdetails').style.visibility = 'visible';
    } else {

    document.getElementById('bankdetails').style.visibility = 'hidden';

    }

    return false;
    }
                                      