<!DOCTYPE html>
<html lang="en">

<head>
  <title>View Draft</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- External CSS libraries -->
  <!-- Favicon icon -->
  <link rel="shortcut icon" href="{{ asset('assets/frontend/assets/img/favicon.ico') }}" type="image/x-icon" />

  <!-- Google fonts -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700" />
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />

  <!-- Custom Stylesheet -->
</head>
<style>
  @font-face {
    font-family: 'DejaVu Sans';
    src: url('/assets/fonts/DejaVuSans.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
  }

  .draft.container {
    font-size: 14px;
    font-family: 'DejaVu Sans', sans-serif;
  }
  .draft.container p {
    margin-bottom: 0.5rem;
  }

  .draft.container p {
    margin-bottom: 0.5rem;
  }

  .container {
    padding: 8px 20px;
  }

  #details-table {
    margin-top: 2%;
  }

  #details-table th,
  #details-table td {
    padding: 0.25em 0 !important;
  }

  #details-table thead {
    background: #ace;
  }

  #details-table th,
  #details-table td {
    text-align: center;
  }

  #details-table tbody tr:nth-child(even) {
    background: #def;
  }

  #details-table tbody tr:nth-child(odd) {
    background: #cadfff;
  }
</style>

<body id="top">
  <!-- Login 8 section start -->
  <nav class="navbar">
    <!-- <div class="container"> -->
    <div class="row align-items-center">
      <div class="col-lg-12" style="padding: 0 30px">
        @php
        $logoPath = config('constants.ldo_logo_path');
        $reasons = ['change in area', ' change in land status', 'property re-entered by L&DO'];
        if(isset($rgr)){
        $allArciveRGRs = [$rgr]; // changed to handle multiple RGRs. Coverting single oblect to array;
        }
        @endphp
        <a class="navbar-brand" href="#">
          <img src="{{ $logoPath }}" alt="Land and Development Office" height="60" />
        </a>
      </div>
    </div>
    <!-- </div> -->
  </nav>
  <div>
    <div class="container draft">
      <div class="row">
        <div class="col-lg-12">
          <p>Dear lessee</p>
          <h5>Subject: &nbsp; Rveision of Ground Rent</h5>
          <input type="hidden" id="pdf-path" value="{{$allArciveRGRs[0]->draft_file_path}}">
          @if(isset($withdrawn))
          <p>We are writing to inform you about an important update regarding the ground rent for the property leased against your name, located at {{ $allArciveRGRs[0]->address }}. The ground rent for the period {{ date('d F Y', strtotime($withdrawn->from_date)) }} to {{ date('d F Y', strtotime($withdrawn->till_date)) }} has been withdrawn because of {{$reasons[$allArciveRGRs[0]->reason_for_change-1]}}.</p>

          <p> New ground rent demand with id {{$demandId ?? '.......'}} has been generated for the property. Please make payment according to the updated ground rent. Any payments that is already made by you will be adjusted</p>

          @elseif(isset($rgr))
          <p>We are writing to inform you about an important update regarding the ground rent for the property leased against your name, presently known as {{ $rgr->address }}. The ground rent of the property has been revised for the period from {{ date('d F Y', strtotime($rgr->from_date)) }} to {{ date('d F Y', strtotime($rgr->till_date)) }}. The revision has been made in accordance with {{$rgr->calculated_on_rate == "L" ? 'L&DO rates':'circle rates'}}.</p>

          <p> New ground rent demand with id {{$demandId ?? '.......'}} has been generated for the property. Payment for the ground rent will be accepted against this demand id. All previous pending ground rent payments (If any) is added in this demand.</p>
          @endif
          <p>Please find below the detailed breakdown of the revised ground rent calculations:</p>

          @foreach($allArciveRGRs as $rgr )
          <table class="table" id="details-table" style="width: 100%;"> <!--width 100% added for pdf. In blade view it is not required-->
            <thead>
              <tr>
                <th>Particulars</th>
                <th>Value</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Address</th>
                <td>{{$rgr->address}}</td>
              </tr>
              <tr>
                <th>Area In Sq. M. </th>
                <td>{{customNumFormat(round($rgr->property_area_in_sqm,2))}}</td>
              </tr>
              @php
              $calculationColumn = $rgr->calculated_on_rate == "L" ? 'lndo':'circle';
              $periodString = $rgr->{$calculationColumn.'_land_rate_period'};
              if(strpos($periodString,'before')!== false){
              $period = 'Land rates applicable before '. date("d F Y", strtotime(str_replace('before ','',$periodString)));
              }
              if(strpos($periodString,'onwards')!== false){
              $period = 'Land rates applicable since - '.date("d F Y", strtotime(str_replace(' onwards','',$periodString)));
              }
              if(strpos($periodString,' - ')!== false){
              list($d1, $d2) = explode(' - ',$periodString);
              $period = 'Land rate aplicable for period - '.date("d F Y", strtotime($d1)). ' to '.date("d F Y", strtotime($d));
              }
              @endphp
              <tr>
                <th>Land Rate</th>
                <td>&#8377;{{customNumFormat(round($rgr->{$calculationColumn.'_land_rate'},2)).'/sqm ('.$period.')'}}</td>
              </tr>
              <tr>
                <th>Land Value</th>
                <td>&#8377;{{customNumFormat(round($rgr->{$calculationColumn.'_land_value'},2))}}</td>
              </tr>
              <tr>
                <th>Ground Rent Per Annum</th>
                <td>&#8377;{{customNumFormat(round($rgr->{$calculationColumn.'_rgr_per_annum'},2))}}</td>
              </tr>
              <tr>
                <th>Period of Ground rent </th>
                <td>{{date('d F Y',strtotime($rgr->from_date)). ' to '. date('d F Y',strtotime($rgr->till_date))}}</td>
              </tr>
              <tr>
                <th>Number of Days</th>
                <td>{{$rgr->no_of_days}}</td>
              </tr>
              <tr>
                <th>Ground Rent Payable</th>
                <td>&#8377;{{customNumFormat(round($rgr->{$calculationColumn.'_rgr'}))}}/-</td>
              </tr>

            </tbody>
          </table>
          @endforeach
          <p>We kindly request you to ensure that the revised ground rent amount is paid by date {{date('d F Y', strtotime('+6 months'))}}. Prompt payment will help in maintaining the smooth operation and upkeep of the property, as well as avoiding any potential penalties for late payment.</p>

          <p>If you have any questions or require further clarification regarding the revised ground rent or the payment process, please do not hesitate to contact our office.</p>
          <p>Please ignore this if already paid.</p>

          <p>Thank you for your attention to this matter. We appreciate your cooperation and timely payment.</p>

          <p>Yours sincerely,</p>
          <p><b>Land and Developemt Office</b></p>
          <p><b>Ministry of Housing aand Urban Affairs</b></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Custom JS Script -->
</body>

</html>