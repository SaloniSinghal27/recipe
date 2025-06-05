// Example: Validate form submission 
document.addEventListener("DOMContentLoaded", () => { 
    const form = document.querySelector("form"); 
    form.addEventListener("submit", (e) => { 
        const name = document.getElementById("name").value.trim(); 
        const description = document.getElementById("description").value.trim(); 
 
        if (!name || !description) { 
            alert("Please fill out all fields before submitting."); 
            e.preventDefault(); 
        } 
    }); 
});