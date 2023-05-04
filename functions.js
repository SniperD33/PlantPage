function showDiv(name) {
    var x = document.getElementById('info');
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
}

function showDivViewPlants(divName, plantName) {
  var x = document.getElementById(divName);
  let sendUpdate = false;
  if (x.style.display === "none") {
    x.style.display = "block";
    sendUpdate = true;
  } else {
    x.style.display = "none";
  }


  if (sendUpdate) {
    let updateData = `UpdateViewCount=true&SciName=${plantName}`;

    fetch("functions.php", {
      method: "POST",
      body: updateData,
      headers: {
        'Content-type': 'application/x-www-form-urlencoded'
      }
    });

    let viewCount = x.getElementsByClassName("viewcount")[0];

    let viewCountNumber = parseInt(viewCount.innerText.split(":")[1]) + 1;

    viewCount.innerText = "ViewCount: " + viewCountNumber;
    
  }
  
}

