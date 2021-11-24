var isHidden = true;
function hideShowNav() {
    var headerNav = document.getElementById('nav-header');
    var screenSize = window.screen.width;
    // alert(screenSize);

    if (isHidden && (screenSize <= 600)) {
        headerNav.classList.add('hide');
        isHidden = false;
    } else {
        headerNav.classList.remove('hide');
        isHidden = true;
    }
}
if (document.getElementById('btnSearch') != null) {
    document.getElementById('btnSearch').addEventListener("click",
        function e(event) {
            event.preventDefault();
            var searchInput = document.getElementById('txtScreenName').value;
            var twytListWrapper = document.getElementById('twyt-list-wrapper');
            fetch('/mytwyt/search/searchProcessor.php',
                {
                    method: 'POST',
                    headers: {
                        "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
                        'Accept': 'application/json'
                    },
                    credentials: 'include',
                    body: 'screenName=' + searchInput
                }
            ).then((res) => res.text())
                .then((data) => twytListWrapper.innerHTML = data)
                .catch((error) => console.log(error));

        }
    );
}


function addToFavorite(twytId, twytText, twytUserScreenName, twytUrl, twytCreatedAt, twytProfileImage) {
    var btnAddedToFavorite = document.getElementById(`btn-${twytId}`);

    if (btnAddedToFavorite.innerHTML == "Add to Favorite") {
        btnAddedToFavorite.setAttribute("disabled", "disabled");


        fetch('/mytwyt/favorites/addFavorite.php',
            {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
                    'Accept': 'application/json'
                },
                credentials: 'include',
                body: 'twytId=' + twytId + '&twytText=' + twytText + '&twytUserScreenName=' + twytUserScreenName + '&twytUrl=' + twytUrl + '&twytCreatedAt=' + twytCreatedAt + '&twytProfileImage=' + twytProfileImage
            }
        ).then((res) => res.json())
            .then((data) => {
                if (data.added) {
                    btnAddedToFavorite.innerText = "Add to Favorite";
                    btnAddedToFavorite.setAttribute("disabled", "disabled");

                } else {
                    btnAddedToFavorite.removeAttribute("disabled");
                    btnAddedToFavorite.disabled = false;

                }
            })
            .catch((error) => console.log(error));

    } else {
        fetch('/mytwyt/favorites/deleteFavorite.php',
            {
                method: 'POST',
                headers: {
                    "Content-type": "application/x-www-form-urlencoded; charset=UTF-8",
                    'Accept': 'application/json'
                },
                credentials: 'include',
                body: 'twytId=' + twytId
            }
        ).then((res) => res.json())
            .then((data) => {
                if (data.removed) {
                    window.location.reload(true);
                }
            }).catch((error) => console.log(error));
    }
}

function shareTwyt(twytId,twytText, twytUserScreenName, twytUrl, twytCreatedAt){
    var btnShareTwyt = document.getElementById(`btn-share${twytId}`);
    if (btnShareTwyt!=null){
       
        if(navigator.share){
            navigator.share({
                title: `Posted by ${twytUserScreenName} @${twytCreatedAt}`,
                text: twytText,
                url: twytUrl
        }).then((console.log('Successful share'))).catch((console.error));
        
     }else{
         alert("Your browser doesn't support share API");
     }
    }

}