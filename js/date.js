         var checkInDate = document.getElementById('checkInDate');
         var checkOutDate = document.getElementById('checkOutDate');
         var today = new Date();
         var dd = String(today.getDate()).padStart(2, '0');
         var mm = String(today.getMonth() + 1).padStart(2, '0');
         var yyyy = today.getFullYear();
         today = yyyy + '-' + mm + '-' + dd;
         checkInDate.setAttribute('min', today);
         checkInDate.onchange = function () {
             checkOutDate.setAttribute('min', this.value);
         }