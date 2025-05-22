     <div class="modal fade" id="viewDraftModal" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-xl">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title">View Revised Ground Rent Draft</h5>
                 </div>
                 <div class="modal-body">
                 </div>
                 <div class="modal-footer">
                     <button onclick="saveAsPdf()" class="btn btn-primary">Generate pdf</button>
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-close">Close</button>
                 </div>
             </div>
         </div>
     </div>

     <script>
         let rgrId;
         const viewDraft = id => {
             rgrId = id;
             let url = "{{ route('viewDraft', ['rgrId' => 'RGR_ID']) }}".replace('RGR_ID', rgrId);
             $('.modal-body').load(url);
             $('#viewDraftModal').modal('show')
         }
         const saveAsPdf = () => {
             $.ajax({
                 type: "get",
                 let url = "{{ route('saveAsPdf', ['id' => 'RGR_ID']) }}".replace('RGR_ID', rgrId);
                 success: response => {

                     setTimeout(() => {
                         //  console.log('hiding')
                         $('#btn-close').click(); //workaround - for some reason $('#viewDraftModal').modal('hide'); not working. reason unknown for now.
                     }, 20);
                     //  $('#viewDraftModal').modal('hide');
                     if (response.status == 'error') {
                         showError(response.details)
                     }
                     if (response.status == 'success') {
                         showSuccess(response.message);
                     }
                 },
                 error: response => {
                     console.log(response)
                 }

             })
         }
     </script>