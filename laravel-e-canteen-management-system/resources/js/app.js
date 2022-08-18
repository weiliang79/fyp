// Bootstrap
import './bootstrap';

// jQuery
import jQuery from 'jquery';
window.$ = jQuery;

// DataTables
import DataTable from 'datatables.net-bs5';
DataTable(window, window.$);

//sweetalert2
import Swal from 'sweetalert2';
window.Swal = Swal;

window.addEventListener('DOMContentLoaded', event => {

      const sidebarToggle = document.body.querySelector('#sidebarToggle');
      if(sidebarToggle){
            sidebarToggle.addEventListener('click', event => {
                  event.preventDefault();
                  document.body.classList.toggle('sb-sidenav-toggled');
                  //localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
            });
      }

      $('.dataTable').DataTable();

})
