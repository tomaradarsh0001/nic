@extends('layouts.app')
@section('title', 'Edit RGR')
@section('content')
<style>
  .heading-container {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5em;
    padding: 0 0.75em !important;
  }

  .heading-container button {
    max-height: 40px !important;
  }
</style>

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
  <div class="breadcrumb-title pe-3">RGR</div>
  <div class="ps-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0 p-0">
        <li class="breadcrumb-item">
          <a href="javascript:;"><i class="bx bx-home-alt"></i></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page"></li>
      </ol>
    </nav>
  </div>
</div>
<!-- <div class="ms-auto"><a href="#" class="btn btn-primary">Button</a></div> -->

<hr />

<div class="card">
  <div class="card-body">
    <div class="container-fluid">
      <div class="col-lg-12 mb-2 heading-container">
        <h5 class="pt-3 text-decoration-underline">Editable RGR</h5>
        <button type="button" class="btn btn-primary d-none" id="btnPostAllSelected">Update RGR for selcted properties</button>
      </div>
      <div class="container-fluid pb-3">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>
                <input type="checkbox" class=" check-header">
              </th>
              <th>Address</th>
              <th>From Date</th>
              <th>Till Date</th>
              @php
              $shouldShowArea = false;
              $colspan = 6;
              switch($reason){
              case 1:
              $shouldShowArea = true;
              $strOldArea = "Old Area";
              $strUpdatedArea = "Updated Area";
              $strUpdateDate = "Area Change Date";
              $changeDate = "update_date";
              $colspan = 8;
              break;
              case 2:
              $strUpdateDate = "Free Hold Date";
              $changeDate = "transferDate";
              break;
              case 3:
              $strUpdateDate = "Re Entry Date";
              $changeDate = "reentry_date";
              break;
              }
              @endphp
              @if($shouldShowArea)
              <th>Old Area</th>
              <th>Updated Area</th>
              @endif
              <th>{{$strUpdateDate}}</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $row)
            <tr>
              <th>
                <input type="checkbox" class="check-body" data-old-id="{{$row->rgr_id}}" data-from_date="{{$row->from_date}}" @if($reason==1) data-old_area="{{$row->old_area}}" data-updated_area="{{$row->updated_area}}" @endif data-till_date="{{$row->till_date}}" data-change_date="{{$row->{$changeDate} }}" data-reason_for_change="{{$reason}}">
              </th>
              <td>{{$row->address}}</td>
              <td>{{date('d-m-Y', strtotime($row->from_date))}}</td>
              <td>{{date('d-m-Y', strtotime($row->till_date))}}</td>
              @if($shouldShowArea)
              <td>{{round($row->old_area,2)}}</td>
              <td>{{round($row->updated_area,2)}}</td>
              @endif
              <td>{{date('d-m-Y', strtotime($row->{$changeDate}))}}</td>
              <td>
                <button class="btn btn-warning btn-update-rgr-row">Update</button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="{{$colspan}}" class="text-center">
                <h5>No data found</h5>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
@section('footerScript')
<script>
  let postData = [];
  $('.check-header').change(function() { //when check box in header is clicked then add/ remove all the rows in the table
    var table = $(this).closest('table');
    var isChecked = $(this).is(':checked');
    if (table.length > 0) {
      // table.find('.check-body').prop('checked', $(this).is(':checked')).trigger('change');
      table.find('.check-body').each(function(i, elm) {
        $(elm).prop('checked', isChecked).trigger('change');
      })
    }
  });

  $(document).on('change', '.check-body', function() {
    var oldId = $(this).data('oldId');
    if ($(this).is(':checked')) {
      //add data for selected row in postData;
      let rowData = createPostData($(this));
      postData.push(rowData);
    } else {
      postData.splice(postData.findIndex(item => item.oldId == oldId), 1);
    }
    if (postData.length > 0) {
      if ($('#btnPostAllSelected').hasClass('d-none')) {
        $('#btnPostAllSelected').removeClass('d-none')
      }
    } else {
      if (!$('#btnPostAllSelected').hasClass('d-none')) {
        $('#btnPostAllSelected').addClass('d-none')
      }
    }
  })
  $('#btnPostAllSelected').click(function() {
    submiData(postData);
  });
  $('.btn-update-rgr-row').click(function() {
    var checkbox = $(this).closest('tr').find('.check-body');
    if (checkbox) {
      var target = $(checkbox[0]);
      var updateData = createPostData(target);
      submiData([updateData])
    }
  });

  function submiData(data) {
    if (data.length > 0 && confirm("This action will withdraw " + data.length + " seleted entrie(s) and create new entries with corresponding end date. Continue?")) {

      $.ajax({
        type: "post",
        url: "{{route('editMultipleRGR')}}",
        data: {
          data: data,
          _token: "{{ csrf_token() }}"
        },
        success: function(response) {
          // console.log(response);
          window.location.reload();
        },
        error: function(error) {
          if (error.responseJSON && error.responseJSON.message) {
            showError(error.error.message)
          }
        }
      })
    }
  }

  function createPostData(element) {
    let oldId = element.data('oldId')
    let reasonForChange = element.data('reason_for_change');
    let fromDate = element.data('from_date');
    let tillDate = element.data('till_date');
    let changeDate = element.data('change_date');
    let fromDateArray = [];
    let tillDateArray = [];
    let oldArea = element.data('old_area');
    let updatedArea = element.data('updated_area');
    let areaArray = [oldArea, updatedArea];
    let postData;
    if (reasonForChange == 1) {
      let fromDate1 = fromDate;
      fromDateArray.push(fromDate1)
      let tillDate1 = changeDate;
      tillDateArray.push(tillDate1);
      let nextDay = new Date(tillDate1);
      nextDay.setDate(nextDay.getDate() + 1);
      let day = nextDay.getDate().toString().padStart(2, '0'); // Ensure day is always two digits
      let month = (nextDay.getMonth() + 1).toString().padStart(2, '0'); // Ensure month is always two digits
      let year = nextDay.getFullYear(); // Get the year
      let fromDate2 = `${day}-${month}-${year}`; // Format date as dd-mm-yyyy
      fromDateArray.push(fromDate2);
      tillDateArray.push(tillDate);
      postData = {
        oldId: oldId,
        from_date: fromDateArray,
        till_date: tillDateArray,
        reason_for_change: reasonForChange,
        area: areaArray,
        area_changed: 1
      }

      // let fromDate2 = dateToYYYYMMDD(nextDay);
    } else {
      fromDateArray.push(element.data('from_date'));
      tillDateArray.push(element.data('change_date'));
      postData = {
        oldId: oldId,
        from_date: fromDateArray,
        till_date: tillDateArray,
        reason_for_change: reasonForChange
      }
    }
    return postData;

  }
</script>

@endsection