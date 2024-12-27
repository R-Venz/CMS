<?php

//========================================================================================================================================================================================================================================================
// Filename: pdfviewer.php
// Coded by: Armando T. Saguin
// Email   : saguin.armando.jr@gmail.com
//========================================================================================================================================================================================================================================================
 
 
class PDF_Viewer{
   function __construct(){
	echo
	"
		<script type='text/javascript' language='javascript'>
			function Hide_PDFViewer(){ 
				var iframe = document.getElementById('PDF_Frame');
				var html = '';
				iframe.contentWindow.document.open();
				iframe.contentWindow.document.write(html);
				iframe.contentWindow.document.close();
				document.getElementById('DataTitle').innerHTML='Loading . . .'; 
			}

			function Show_PDFViewer(pdf_File,caption){
				Hide_PDFViewer()
				var iframe = document.getElementById('PDF_Frame');
				var html = '';
				iframe.contentWindow.document.open();
				iframe.contentWindow.document.write(html);
				iframe.contentWindow.document.close();

				document.getElementById('DataTitle').innerHTML=caption;
				document.getElementById('PDF_Frame').src=pdf_File;
			}
		</script>
	";
		echo'
			<!-- popWall -->
			    <div class="modal fade" id="PopupWall" role="dialog">
			      <div class="modal-dialog modal-lg">
			        <div class="modal-content">
			          <div class="modal-header">
			            <button type="button" class="close" data-dismiss="modal">&times;</button>
			            <h4 class="modal-title" id="DataTitle">Loading . . .</h4>
			          </div>
			          <div class="modal-body">
			            <div class="panel-body">
			                <div class="form">
			                  <div id="submit_form" class="form-validate form-horizontal">
			                    <div class="form-group ">
			                      <label for="maker" class="control-label col-lg-2"></label>
			                      <div class="col-lg-12">
										<table height="450px" width="100%">
											<tr>
												<td>
													<iframe style="width:99.7%; height:450px; top:0px;" src="" id="PDF_Frame">
														Loading of PDF File....
													</iframe>
												</td>
											</tr>
										<table>
			                      </div>
			                    </div>
			                  </div>
			                </div>
			              </div>
			          </div>
			          <div class="modal-footer">
			            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			          </div>
			        </div>
			      </div>
			    </div>
			<!-- End popWall -->
		';
	     
     }
	 
	 
   }
?>