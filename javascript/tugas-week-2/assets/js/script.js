/** Data Lowongan */
const vacancies = [
    {
        lowongan_id: 1,
        lowongan_name: "Junior Programmer",
        positions: [
            {
                position_id: 1,
                position_name: "Junior Programmer - Bandung"
            },
            {
                position_id: 2,
                position_name: "Junior Programmer - Jakarta"
            }
        ],
        available_quota: 1
    },
    {
        lowongan_id: 2,
        lowongan_name: "Senior Programmer",
        positions: [
            {
                position_id: 3,
                position_name: "Senior Programmer - Bandung"
            },
            {
                position_id: 4,
                position_name: "Senior Programmer - Jakarta"
            }
        ],
        available_quota: 2
    },
    {
        lowongan_id: 3,
        lowongan_name: "System Administrator",
        positions: [
            {
                position_id: 5,
                position_name: "System Administrator - Bandung"
            },
            {
                position_id: 6,
                position_name: "System Administrator - Jakarta"
            }
        ],
        available_quota: 3
    },
    {
        lowongan_id: 4,
        lowongan_name: "Mobile Developer",
        positions: [
            {
                position_id: 7,
                position_name: "Mobile Developer - Bandung"
            },
            {
                position_id: 8,
                position_name: "Mobile Developer - Jakarta"
            }
        ],
        available_quota: 4
    },
];

/** Loop dan mapping lowongan */
const selectLowongan = document.getElementById("lowongan");

vacancies.forEach((value) => {
    let option = new Option(value.lowongan_name, value.lowongan_id)
    selectLowongan.append(option);
})

/** Loop dan mapping posisi */
const selectPosisi = document.getElementById("posisi");

selectLowongan.addEventListener("change", function () {
    // Reset dulu
    selectPosisi.innerHTML = ""
    let disabledOption = new Option("- Pilih Posisi -")
    selectPosisi.append(disabledOption)

    if (selectLowongan.parentElement.querySelector("p")) {
        selectLowongan.parentElement.querySelectorAll("p").forEach((e) => {
            e.remove()
        })
    }

    /** Validasi quota sudah terisi */
    if (!checkVacanciesQuotaIsAvailable(this.value)) {
        const elPErr = document.querySelector(".error-info").cloneNode()
        elPErr.classList.remove("hidden")
        elPErr.textContent = `Mohon maaf, rekrutasi untuk ${getTextContentOption(this)} sudah penuh. dan tidak dapat dipilih`;
        selectLowongan.parentElement.append(elPErr)
        return false;
    }

    /** Mapping posisi sesuai lowongan */
    const { positions } = vacancies.find((value) => value.lowongan_id == this.value)
    positions.forEach((value) => {
        let option = new Option(value.position_name, value.position_id)
        selectPosisi.append(option);
    })

    /** Validasi jika <= 2 maka tampilkan informasi berikut */
    let sisaQuota = checkSisaQuota(this.value)
    if (sisaQuota <= 2) {
        const elPWarning = document.querySelector(".warning-info").cloneNode()
        elPWarning.classList.remove("hidden")
        elPWarning.textContent = `Kuota tersisa untuk ${getTextContentOption(this)} hanya ${sisaQuota} pendaftar.`;
        selectLowongan.parentElement.append(elPWarning)
        return false
    }

    /** Informasi dapat memilih lowongan */
    const elPSuccess = document.querySelector(".success-info").cloneNode()
    elPSuccess.classList.remove("hidden")
    elPSuccess.textContent = `Anda dapat memilih lowongan ${getTextContentOption(this)}`;
    selectLowongan.parentElement.append(elPSuccess)

});

/** Validasi email */
document.getElementById("email").addEventListener("change", function () {
    this.parentElement.querySelector("p") ? this.parentElement.querySelector("p").remove() : ""
    const isAlreadyUsed = applicants.find((applicant) => applicant.email === this.value)
    if (isAlreadyUsed) {
        const elPErr = document.querySelector(".error-info").cloneNode()
        elPErr.classList.remove("hidden")
        elPErr.textContent = `Email tersebut sudah digunakan`;
        this.parentElement.append(elPErr)
    }
})

/** Action submit form receruitment */
document.getElementById("form-recruitment").onsubmit = (e) => {
    e.preventDefault()

    /** Dapetin element nya */
    const elements = document.querySelectorAll('#form-recruitment input, #form-recruitment option:checked');

    /** Validasi mandatory */
    const allEmptyArray = Array.from(elements).filter((el) => el.value == "")
    if (allEmptyArray.length) {
        allEmptyArray.forEach((e) => {
            let elPErrMandatory = document.querySelector(".error-info").cloneNode()
            elPErrMandatory.classList.remove('hidden')
            elPErrMandatory.textContent = `Input ini wajib di isi`
            e.closest('.input-wrapper').append(elPErrMandatory)
        })
        return
    }

    const elOptionLowongan = document.getElementById("lowongan");

    /** reset wrapper */
    document.querySelector(".wrapper-list-content").innerHTML = ""

    /** show modal */
    document.getElementById("modal-success-submit").classList.remove("hidden")

    let tempApplicant = {}

    /** Mapping ke card */
    elements.forEach((el) => {
        const clonedListWrapper = document.querySelector(".list-wrapper").cloneNode(true);
        clonedListWrapper.classList.remove("hidden")

        /** Set each title card */
        const title = el.nodeName != "OPTION" ? removeStar(el.parentElement.innerText) : getLabelOption(el)
        clonedListWrapper.querySelector(".list-title").textContent = title

        /** Set each value card */
        const content = el.nodeName != "OPTION" ? el.value : getTextContentOption(el.parentElement)
        clonedListWrapper.querySelector(".list-content").textContent = content

        /** Append to card */
        document.querySelector(".wrapper-list-content").append(clonedListWrapper)

        /** Push ke tempApplicant */
        tempApplicant[title.toLowerCase().trim()] = content
    })

    applicants.push(tempApplicant)

    /** 
     * Menampilkan informasi jumlah orang yang telah melakukan lamaran 
     * ke posisi tersebut
     * */
    document.querySelector('.info-lowongan').innerHTML = ""

    const pElInfoPelamar = document.createElement("p")
    pElInfoPelamar.textContent = `Jumlah pelamar yang telah melakukan apply ke lowongan ${getTextContentOption(elOptionLowongan)}`

    const pElCountPelamar = document.createElement("p")
    pElCountPelamar.textContent = `Adalah ${countApplicantWhoApplied(elOptionLowongan.value)} Orang`;

    document.querySelector('.info-lowongan').append(pElInfoPelamar, pElCountPelamar)

}

function getTextContentOption(el) {
    return el.options[el.selectedIndex].textContent;
}

function getLabelOption(el) {
    const label = el.parentElement.previousElementSibling.textContent
    return removeStar(label)
}

function removeStar(text) {
    return text.replace("*", "")
}

/** Action kalau button close */
document.getElementById("close-modal").onclick = () => {
    resetForm()

    /** hide modal */
    document.getElementById("modal-success-submit").classList.add("hidden")
}

/** Data Pelamar */
const applicants = []

function findApplicantByEmail(email) {
    return applicants.find((applicant) => applicant.email === email)
}

function checkVacanciesQuotaIsAvailable(lowongan_id) {
    const selectedVacancy = vacancies.find(vacancy => vacancy.lowongan_id == lowongan_id)

    const applicantWhoSelectThatVacancy = applicants.filter(applicant => applicant.lowongan == selectedVacancy.lowongan_name)
    return applicantWhoSelectThatVacancy.length !== selectedVacancy.available_quota;
}

function checkSisaQuota(lowongan_id) {
    const selectedVacancy = vacancies.find(vacancy => vacancy.lowongan_id == lowongan_id)
    const applicantWhoSelectThatVacancy = applicants.filter(applicant => applicant.lowongan == selectedVacancy.lowongan_name)
    return selectedVacancy.available_quota - applicantWhoSelectThatVacancy.length
}

function countApplicantWhoApplied(lowongan_id) {
    const selectedVacancy = vacancies.find(vacancy => vacancy.lowongan_id == lowongan_id)
    const applicantWhoSelectThatVacancy = applicants.filter(applicant => applicant.lowongan == selectedVacancy.lowongan_name)

    return applicantWhoSelectThatVacancy.length
}

function resetForm() {
    /** reset form */
    document.getElementById("form-recruitment").reset()

    selectLowongan.parentElement.querySelector("p").remove()
    document.getElementById('email').parentElement.querySelector("p") ? document.getElementById('email').parentElement.querySelector("p").remove() : ""

    document.querySelectorAll('.input-wrapper').forEach((e) => {
        if (e.querySelector("p")) {
            e.querySelector('p').remove()
        }
    })
}