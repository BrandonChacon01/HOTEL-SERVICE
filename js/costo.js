function calculateTotalCost() {
    var numberOfPeople = document.getElementById("request").elements.namedItem("numberOfPeople").value;
    var checkInDate = new Date(document.getElementById("request").elements.namedItem("checkInDate").value);
    var checkOutDate = new Date(document.getElementById("request").elements.namedItem("checkOutDate").value);
    var roomType = document.getElementById("request").elements.namedItem("roomType").value;
    var numeroHabitaciones = 0;
    var totalCost = 0;
    if (numberOfPeople == "" || isNaN(checkInDate) || isNaN(checkOutDate) || roomType == "") {
          return;
    } else{
          var nights = (checkOutDate - checkInDate) / (1000 * 60 * 60 * 24);
          numberOfPeople = parseInt(numberOfPeople);
          if (roomType == "tipo1"){
                if (numberOfPeople > 2){
                      alert("La habitación Executive solo puede albergar a 2 personas. Se reservara una habitación más del mismo tipo conforme se vayan llenando las habitaciones.");
                      if (numberOfPeople % 2 != 0){
                            numeroHabitaciones= numberOfPeople + 1;
                            numeroHabitaciones = numeroHabitaciones / 2;
                      } else{
                            numeroHabitaciones= numberOfPeople;
                            numeroHabitaciones = numeroHabitaciones / 2;
                      }
                } else{
                      numeroHabitaciones = 1;
                }
                totalCost = (1099 * numeroHabitaciones) * nights;
                
          } else if (roomType == "tipo2"){
                if (numberOfPeople > 4){
                      alert("La habitación Deluxe solo puede albergar a 4 personas. Se reservara una habitación más del mismo tipo conforme se vayan llenando las habitaciones.");
                      if (numberOfPeople % 4 != 0){
                        numeroHabitaciones = numberOfPeople;
                        while (numeroHabitaciones % 4 != 0) {
                              numeroHabitaciones++;
                        }
                        numeroHabitaciones = numeroHabitaciones / 4;
                  } else{
                        numeroHabitaciones= numberOfPeople;
                        numeroHabitaciones = numeroHabitaciones / 4;
                  }

                } else{
                      numeroHabitaciones = 1;
                }
                totalCost = (799 * numeroHabitaciones) * nights;
          }
    }
    document.getElementById("request").elements.namedItem("totalCost").value = totalCost;
 }
 document.getElementById("request").elements.namedItem("numberOfPeople").addEventListener("change", calculateTotalCost);
 document.getElementById("request").elements.namedItem("checkInDate").addEventListener("change", calculateTotalCost);
 document.getElementById("request").elements.namedItem("checkOutDate").addEventListener("change", calculateTotalCost);
 document.getElementById("request").elements.namedItem("roomType").addEventListener("change", calculateTotalCost);