let isHidden = true;
let isShareClicked = false;
let isAddFavoriteClicked = false;
let twyts = [];
let selectedTwyts = [];
let splitted = [];

function hideShowNav() {
  var headerNav = document.getElementById("nav-header");
  var screenSize = window.screen.width;

  if (isHidden && screenSize <= 950) {
    headerNav.classList.add("hide");
    document.getElementById("action-header").style.top = "54px";
    isHidden = false;
  } else if (screenSize > 950) {
    document.getElementById("action-header").style.top = "54px";
    headerNav.classList.remove("hide");
    isHidden = false;
  } else {
    headerNav.classList.remove("hide");
    document.getElementById("action-header").style.top = "340px";
    isHidden = true;
  }
}
if (document.getElementById("btnSearch") != null) {
  document
    .getElementById("btnSearch")
    .addEventListener("click", function e(event) {
      event.preventDefault();
      var searchInput = document.getElementById("txtScreenName").value;
      var twytListWrapper = document.getElementById("twyt-list-wrapper");
      var searchProgressContainer = document.getElementById(
        "searchProgressContainer"
      );
      searchProgressContainer.classList.remove("hide");

      fetch("/mytwyt/search/searchProcessor.php", {
        method: "POST",
        headers: {
          "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
          Accept: "application/json",
        },
        credentials: "include",
        body: "screenName=" + searchInput,
      })
        .then((res) => res.text())
        .then((data) => {
          searchProgressContainer.classList.add("hide");
          twytListWrapper.innerHTML = data;
        })
        .catch((error) => {
          searchProgressContainer.classList.add("hide");
          console.log(error);
        });
    });
}

function selectAll() {
  let chkFavorites = [];
  console.log("All twyts selected");
  chkFavorites = document.getElementsByName("selFavorite");
  chkFavorites.forEach((chkItem) => {
    //chkItem.setAttribute("checked","checked");

    chkItem.toggleAttribute("checked");
  });
}

function twytsSelected() {
  // let twyts;
  // let selectedTwyts = [];
  // let splitted = [];
  twyts = Array.from(document.getElementsByClassName("tywt-wrapper"));
  for (const twyt of twyts) {
    if (
      isAddFavoriteClicked &&
      twyt.children[4].children[1].children[0].checked
    ) {
      // console.log(isAddFavoriteClicked +':'+isAddFavoriteClicked);

      if (twyt.children[4].children[1].children[2].hasAttribute("disabled")) {
        continue;
      }

      splitted = twyt.children[4].children[0].textContent.split("@");
      selectedTwyts.push({
        twytId: twyt.id,
        twytImage: twyt.children[0].children[0].attributes[0].textContent,
        twytText: twyt.children[0].children[1].textContent,
        twytUrl: twyt.children[1].children[0].textContent,
        twytUserScreenName: splitted[0].trim(),
        twytCreatedAt: splitted[1].trim(),
        selected: twyt.children[4].children[1].children[0].checked,
      });
    }
    if (isShareClicked && twyt.children[4].children[1].children[0].checked) {
      splitted = twyt.children[4].children[0].textContent.split("@");
      selectedTwyts.push({
        twytId: twyt.id,
        twytImage: twyt.children[0].children[0].attributes[0].textContent,
        twytText: twyt.children[0].children[1].textContent,
        twytUrl: twyt.children[1].children[0].textContent,
        twytUserScreenName: splitted[0].trim(),
        twytCreatedAt: splitted[1].trim(),
        //selected : twyt.children[4].children[1].children[0].checked
      });
    }
  }
  return selectedTwyts;
  // console.log(twyts[0].children[4].children[1].children[0].checked);
  //console.log(twyts[0].children[1].children[0].textContent);//twytUrl
  // //console.log(twyts[0].children[4].children[1].children[2].hasAttribute('disabled'));
  // console.log(twyts[0].children[0].children[0].attributes[0].textContent);//twytImage
  // console.log(twyts[0].children[0].children[1].textContent);//twytText
  //console.log(twyts[0].children[4].children[0].textContent);//twytUserScreenName-twytCreatedAt
  // let splitted = [];
  // splitted = twyts[6].children[4].children[0].textContent.split("@");
  // console.log(splitted[0].trim());//twytUserScreenName
  // console.log(splitted[1].trim());//twytCreatedAt
  //console.log(twyts[0].id)//twytId;
}

// function isSelected(arrCard){

// }

function addFavoritesSelected() {
  let favoritesSelected = [];
  let strFavoriteSelected = "";
  isAddFavoriteClicked = true;

  let bodyTag = document.getElementById("site-body");
  let btnFavoritesSelected = document.getElementById("btnFavoritesSelected");
  bodyTag.style.cursor = "wait";
  favoritesSelected = twytsSelected();
  strFavoriteSelected = JSON.stringify(favoritesSelected);
//   console.log(btnFavoritesSelected.innerHTML.trim());
//   return;
  if (favoritesSelected.length == 0) {
    alert(
      "Please, select atleast One(1) Twyt that is not already added to favorite"
    );
    bodyTag.style.cursor = "default";
    return;
  }
  if (btnFavoritesSelected.innerHTML.trim() == "Remove Favorites"){
    console.log("Remove Favorites button clicked");
    //bodyTag.style.cursor = "wait";
    fetch("/mytwyt/favorites/deleteFavoritesSelected.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json; charset=UTF-8",
          Accept: "application/json",
        },
        credentials: "include",
        body: strFavoriteSelected,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Success:", data);
        })
        .catch((error) => {
          bodyTag.style.cursor = "default";
          console.log("Error:", error);
        });
    
      //   console.log(strFavoriteSelected);
      isAddFavoriteClicked = false;
      twyts = [];
      selectedTwyts = [];
      splitted = [];
      console.log(favoritesSelected);
      
    
      setTimeout(
        ()=>{
            location.reload(true);
        },2000);
        bodyTag.style.cursor = "default";
  }

  if (btnFavoritesSelected.innerHTML.trim() == "Add Favorites"){
    console.log("Add Favorites button clicked");
    //bodyTag.style.cursor = "wait";
    // strFavoriteSelected = JSON.stringify(favoritesSelected);

  fetch("/mytwyt/favorites/addFavoritesSelected.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json; charset=UTF-8",
      Accept: "application/json",
    },
    credentials: "include",
    body: strFavoriteSelected,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Success:", data);
    })
    .catch((error) => {
      bodyTag.style.cursor = "default";
      console.log("Error:", error);
    });

  //   console.log(strFavoriteSelected);
  isAddFavoriteClicked = false;
  twyts = [];
  selectedTwyts = [];
  splitted = [];
  console.log(favoritesSelected);
  

  setTimeout(
    ()=>{
        location.reload(true);
    },2000);
    bodyTag.style.cursor = "default";
  }

}

function shareSelected() {
  let sharesSelected = [];
  isShareClicked = true;
  sharesSelected = twytsSelected();
  if (sharesSelected.length == 0) {
    alert("No Twyt selected. Please, select atleast One(1) Twyt");
    return;
  }
  if (navigator.share) {
    sharesSelected.forEach((twyt) => {
      navigator
        .share({
          title: `Posted by ${twyt.twytUserScreenName} @${twyt.twytCreatedAt}`,
          text: twyt.twytText,
          url: twyt.twytUrl,
        })
        .then(console.log("Successful share"))
        .catch(console.error);
    });
  } else {
    alert("Your browser doesn't support share API");
  }

  isShareClicked = false;
  twyts = [];
  selectedTwyts = [];
  splitted = [];
  console.log(sharesSelected);
}

function addToFavorite(
  twytId,
  twytText,
  twytUserScreenName,
  twytUrl,
  twytCreatedAt,
  twytProfileImage
) {
  var btnAddedToFavorite = document.getElementById(`btn-${twytId}`);
  let bodyTag = document.getElementById("site-body");
  bodyTag.style.cursor = "wait";
  if (btnAddedToFavorite.innerHTML == "Add to Favorite") {
    btnAddedToFavorite.setAttribute("disabled", "disabled");

    fetch("/mytwyt/favorites/addFavorite.php", {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
        Accept: "application/json",
      },
      credentials: "include",
      body:
        "twytId=" +
        twytId +
        "&twytText=" +
        twytText +
        "&twytUserScreenName=" +
        twytUserScreenName +
        "&twytUrl=" +
        twytUrl +
        "&twytCreatedAt=" +
        twytCreatedAt +
        "&twytProfileImage=" +
        twytProfileImage,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.added) {
          btnAddedToFavorite.innerText = "Add to Favorite";
          btnAddedToFavorite.setAttribute("disabled", "disabled");
        } else {
          btnAddedToFavorite.removeAttribute("disabled");
          btnAddedToFavorite.disabled = false;
        }
      })
      .catch((error) => {
        bodyTag.style.cursor = "default";
        console.log(error);
    });
    bodyTag.style.cursor = "default";
  } else {
    btnAddedToFavorite.setAttribute("disabled", "disabled");
    fetch("/mytwyt/favorites/deleteFavorite.php", {
      method: "POST",
      headers: {
        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
        Accept: "application/json",
      },
      credentials: "include",
      body: "twytId=" + twytId,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.removed) {
          window.location.reload(true);
        }
      })
      .catch((error) => {
        btnAddedToFavorite.setAttribute("disabled", "");
        bodyTag.style.cursor = "default";
        console.log(error);
      });
      bodyTag.style.cursor = "default";
  }
}

function shareTwyt(
  twytId,
  twytText,
  twytUserScreenName,
  twytUrl,
  twytCreatedAt
) {
  var btnShareTwyt = document.getElementById(`btn-share${twytId}`);
  if (btnShareTwyt != null) {
    if (navigator.share) {
      navigator
        .share({
          title: `Posted by ${twytUserScreenName} @${twytCreatedAt}`,
          text: twytText,
          url: twytUrl,
        })
        .then(console.log("Successful share"))
        .catch(console.error);
    } else {
      alert("Your browser doesn't support share API");
    }
  }
}

function fetchSearchTerm() {
  var searchInput = document.getElementById("txtScreenName");
  var twytListWrapper = document.getElementById("twyt-list-wrapper");
  var searchProgressContainer = document.getElementById(
    "searchProgressContainer"
  );

  if (!searchInput) return;
  if (searchInput.value == "") return;
  searchProgressContainer.classList.remove("hide");
  fetch("/mytwyt/search/searchProcessor.php", {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
      Accept: "application/json",
    },
    credentials: "include",
    body: "screenName=" + searchInput.value,
  })
    .then((res) => res.text())
    .then((data) => {
      searchProgressContainer.classList.add("hide");
      twytListWrapper.innerHTML = data;
    })
    .catch((error) => {
      searchProgressContainer.classList.add("hide");
      console.log(error);
    });
}

window.onload = fetchSearchTerm();
