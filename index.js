
let current_active_section = 'get';
const endpoint_url = 'webservices/rest-api.php?';
const all_superpowers = ["strength", "speed", "flight", "invulnerability", "healing"];

hideSectionElements = () => {
    document.querySelectorAll('.section-content').forEach((section) => {
        section.style.display = 'none';
    }) 
}

hideSectionElements();
document.querySelectorAll('.get-section').forEach((e) => e.style.display = 'block'); // set default section

document.querySelectorAll('input[name="http-methods"]').forEach((btn) => {
    btn.addEventListener('change', function() {
        hideSectionElements();
        current_active_section = this.value.toLowerCase();
        const selectedContent = document.querySelector(`.${current_active_section}-section`);
        if (selectedContent) {
            selectedContent.style.display = 'block';
        }
    })
});

document.querySelectorAll('.input').forEach(inputElement => {
    inputElement.addEventListener('input', (event) => {
        event.target.value = event.target.value.replace(/[^a-z ]/g, '').toLowerCase();
    });
});

document.getElementById('key').addEventListener('keydown', (event) => {
    if (event.key = 'Enter') {
        event.preventDefault();
    }
});

document.getElementById('submit-button').addEventListener('click', () => {
    if (current_active_section === 'get') {

        let superpower_checkboxes = document.querySelector('input[class="filters"]:checked');
        if (superpower_checkboxes != null) {

            const form = document.querySelector('#get-form');
            const formData = new FormData(form);
            const url = endpoint_url + new URLSearchParams(formData).toString();

            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                let response = xhr.responseText.replace(/\n/g, '<br>');
                document.querySelector('#result').innerHTML = response;
            };
            xhr.open('GET', url);
            xhr.send();
        }
        else alert('Please select at least one Superpower');
    }
    else if (current_active_section === 'post') {

        const nm = document.getElementById('nm').value;
        const fn = document.getElementById('fn').value;
        const ln = document.getElementById('ln').value;
        const dob = document.getElementById('dob').value;

        if (!nm.trim()) {
            alert('Please provide a name');
        }
        else if (!fn.trim()) {
            alert('Please provide a firstname');
        }
        else if (!ln.trim()) {
            alert('Please provide a lastname');
        }
        else {
            let superpower_checkboxes = document.querySelector('input[class="suppwrs"]:checked');
            if (superpower_checkboxes != null) {

                let selected_superpowers = [];
                document.querySelectorAll('.suppwrs').forEach((checkbox, idx) => {
                    if (checkbox.checked) {
                      selected_superpowers.push(all_superpowers[idx]);  
                    }
                });

                let xhr = new XMLHttpRequest();
                xhr.onreadystatechange = () => {
                    document.getElementById('result').innerHTML = xhr.responseText;
                }

                let data = JSON.stringify({
                    'name': nm,
                    'identity': {
                        'firstName': fn,
                        'lastName': ln
                    },
                    'birthday': dob,
                    'superpowers': selected_superpowers
                });
                
                xhr.open('POST', endpoint_url);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send(data);
                document.getElementById("post-form").reset();
            }
            else alert('Please select at least one Superpower');
        }
    }
});
