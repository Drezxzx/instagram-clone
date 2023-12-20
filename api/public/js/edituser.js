function editUser() {
    const formedituser = document.querySelector(".edit-user-secction");
    const confirmButton = document.getElementById("confirm-user");

    formedituser.classList.toggle("hidden");

    confirmButton.addEventListener("click", async (e) => {
        e.preventDefault();

        const username = document.getElementById("username").value;
        const name = document.getElementById("nameuser").value;
        const lastname = document.getElementById("lastnameuser").value;
        const description = document.getElementById("Description").value;
        const imageInput = document.getElementById("image");
        const imageFile = imageInput.files[0];
        console.log(imageFile);
        const dataRequest = new FormData();
        dataRequest.append("name", name);
        dataRequest.append("lastname", lastname);
        dataRequest.append("username", username);
        dataRequest.append("description", description);
        dataRequest.append("img", imageFile);

        const response = await fetch(location.origin + "/api/src/models/edituser.php", {
            method: "POST",
            body: dataRequest,
        });

        try {
            const data = await response.json();
            if (data) {
                console.log(data);
                
            }
        } catch (error) {
            console.error(error);
        }
    });
}

