function verifier() {
    let numeroCarte = document.getElementById("numero").value;
    let nom = document.getElementById("nom").value;
    let prenom = document.getElementById("prenom").value;
    let dateNaissance = document.getElementById("dateNaissance").value;

    let pere = document.getElementById("pere").value;
    let mere = document.getElementById("mere").value;
    let province = document.getElementById("province").value;
    let commune = document.getElementById("commune").value;
    let zone = document.getElementById("zoneRes").value;
    let etatCivil = document.getElementById("etatCivil").value;
    let fonction = document.getElementById("fonction").value;
    let residenceActuel = document.getElementById("residenceActuel").value;
    let nationalite = document.getElementById("nationalite").value;
    let sexe = document.getElementById("sexe").value;

    if (numeroCarte === "" || nom === "" || prenom === "" || dateNaissance === "" || pere === "" || mere === "" || province === "" || commune === "" || zone === "" || etatCivil === "" || fonction === "" || residenceActuel === "" || nationalite === "" || sexe === "") {

        alert("Remplir les champs");

        return false;
    }
    return true;
}

function chargerCommunes() {
    let province = document.getElementById("province").value;
    let commune = document.getElementById("commune");

    commune.innerHTML = '<option value = "">--commune--</option>';
    let data = {
        "bujumbura": ["muha", 'mukaza', 'ntahangwa'],
        "gitega": ['gitega', 'giheta', 'muramvya'],
        "butanyerera": ['kayanza', 'ngozi', 'matongo']
    };
    if (data[province]) {
        data[province].forEach(function (c) {
            let option = document.createElement("option");
            option.value = c;
            option.text = c;

            commune.appendChild(option);
        });
    }
}

window.onload = genererNumero;

document.getElementById("province").addEventListener("change", genererNumero);
document.getElementById("commune").addEventListener("change", genererNumero);

function genererNumero() {
    let province = document.getElementById("province").value;
    let commune = document.getElementById("commune").value;

    let codeProvince = {
        "bujumbura": "501",
        "gitega": "502",
        "butanyerera": "503"
    }
    let codeCommune = {
        "muha": "312",
        "mukaza": "837",
        "ntahangwa": "646",
        "gitega": "311",
        "giheta": "843",
        "muramvya": "146",
        "kayanza": "122",
        "ngozi": "600",
        "matongo": "623"
    };


    let annee = new Date().getFullYear().toString().slice(-2);
    let r1 = Math.floor(Math.random() * 1000).toString().padStart(3, "0");
    let r2 = Math.floor(Math.random() * 1000).toString().padStart(3, "0");

    let numero = codeProvince[province] + "." +
        codeCommune[commune] + "." +
        annee + "/" +
        r1 + "." + r2;

    document.getElementById("numero").value = numero;
}


const chooseBtn = document.getElementById("chooseImage");
const fileInput = document.getElementById("fileInput");

chooseBtn.addEventListener("click", ()=> {
    fileInput.click();
});
fileInput.onchange = () => {
    let f = fileInput.files[0];
    if(f && f.type.startsWith("image/")) {
        document.getElementById("preview").src = URL.createObjectURL(f);
    }
};