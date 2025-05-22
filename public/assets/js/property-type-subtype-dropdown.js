$(document).ready(function(){
	$("#property-Type").on("change", function () {
	  /** fill property sub type */
	  var idPropertyType = $("#property-Type").val();
	  var targetSelect = $("#prop-sub-type");
	  targetSelect /** remove options from property sub type */
		.find("option")
		.remove()
		.end();
	  targetSelect.selectpicker("refresh");
	  if (idPropertyType) {
		$.ajax({
		  // call for subtypes for selected property types
		  url: "/report/get-distinct-subType", //"{{route('getDistinctSubTypes')}}",
		  type: "POST",
		  data: {
			types: idPropertyType,
			_token: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
		  },
		  dataType: "json",
		  success: function (res) {
			var firstOption = $("<option>", {
			  value: "",
			  text: "All",
			});
			targetSelect.append(firstOption);

			$.each(res, function (key, value) {
			  var newOption = $("<option>", {
				value: value.id,
				text: value.item_name,
			  });
			  targetSelect.append(newOption);
			});
			targetSelect.selectpicker("refresh");
		  },
		});
	  }
	});
});
	
