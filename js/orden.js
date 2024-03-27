var prices = {
      "tipo1": 280,
      "tipo2": 99,
      "tipo3": 345,
      "tipo4": 190,
      "tipo5": 210,
      "tipo6": 149
  };
  
  function calculateTotalCost() {
      var totalCost = 0.0;
      for (var dish in prices) {
          if (document.getElementById(dish).checked) {
              totalCost += prices[dish];
          }
      }
      document.getElementsByName('totalCost')[0].value = totalCost;
  }
  
  // Add event listeners for the checkboxes
  for (var dish in prices) {
      document.getElementById(dish).addEventListener('change', calculateTotalCost);
  }