
    <!-- jQuery -->
    <script src="<?php echo web_root; ?>assets/vendor/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="<?php echo web_root; ?>assets/vendor/popper.js"></script>
    <script src="<?php echo web_root; ?>assets/vendor/bootstrap.min.js"></script>

    <!-- Simplebar -->
    <!-- Used for adding a custom scrollbar to the drawer -->
    <script src="<?php echo web_root; ?>assets/vendor/simplebar.js"></script>


    <!-- Vendor -->
    <script src="<?php echo web_root; ?>assets/vendor/Chart.min.js"></script>
    <script src="<?php echo web_root; ?>assets/vendor/moment.min.js"></script>


    <!-- APP -->
    <script src="<?php echo web_root; ?>assets/js/color_variables.js"></script>
    <script src="<?php echo web_root; ?>assets/js/app.js"></script>


    <script src="<?php echo web_root; ?>assets/vendor/dom-factory.js"></script>
    <!-- DOM Factory -->
    <script src="<?php echo web_root; ?>assets/vendor/material-design-kit.js"></script>
    <!-- MDK -->


    <script src="<?php echo web_root; ?>assets/vendor/morris.min.js"></script>
    <script src="<?php echo web_root; ?>assets/vendor/raphael.min.js"></script>
    <script src="<?php echo web_root; ?>assets/vendor/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo web_root; ?>assets/js/datepicker.js"></script>

    <!-- SweetAlert2 -->
    <script src="<?php echo web_root; ?>assets/libs/sweetalert2/sweetalert2.js"></script>

    <script src="<?php echo web_root; ?>include/classes/javascript/ajax/ajax.js"></script>

    <script src="<?php echo web_root; ?>assets/libs/DataTables/datatables.min.js"></script>

    <script src="<?php echo web_root; ?>assets/vendor/bootstrap-switch.min.js"></script>
    
    <script src="<?php echo web_root; ?>assets/vendor/select2.full.min.js"></script>

    <script type="text/javascript">
        var Ajax= new AJAX();
        function autoSizeDatatableInModal(md) {
           $('#'+md).on('shown.bs.modal', function (e) {
               $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
           });
        }
        function Hide_PDFViewer() {
            document.getElementById('DataTitle').innerHTML='Loading . . .';
            var iframe = document.getElementById('PDF_Frame');
            var html = '<center><br/><br/><h4>Fetching data from the server. <br/>Please wait...</h4>';
            iframe.contentWindow.document.open();
            iframe.contentWindow.document.write(html);
            iframe.contentWindow.document.close();
        }
        function Show_PDFViewer(pdf_File,caption) {
            Hide_PDFViewer();
            document.getElementById('DataTitle').innerHTML=caption;
            document.getElementById('PDF_Frame').src=pdf_File;
        }
    </script>
