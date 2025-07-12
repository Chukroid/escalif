import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const modalBg = document.getElementsByClassName("modal-bg")
const printButton = document.getElementsByClassName("printbutton")
const enviarBoletaBoton = document.getElementsByClassName("enviarBoletaBoton")

// Modalidade
const modalidadToggles = document.querySelectorAll(".modalidad-activo-toggle");

// Curso - Materia
const ModalMateriaCerrarBtn = document.getElementById("modal-materia-cerrar-btn");
const VerMateriasBtn = document.getElementsByClassName("ver-materia-btn")
const ModalMateriaList = document.getElementById("materia-choose-list")

// Select - GrupoMateria
const GMProfesorSelect = document.getElementById("profesor_id");
const GMCursoSelect = document.getElementById("curso_id");
const GMSemestreSelect = document.getElementById("semestre");
const GMMateriaSelect = document.getElementById("materia_id");

// Select -GrupoEstudiante
const GECursoSelect = document.getElementById("curso_id_estudiante");
const GESemestreSelect = document.getElementById("semestre_estudiante");

function cerrarModal(){
    [...modalBg].forEach((item, index) => {
        item.style.display = 'none';
    });
}
function abrirModal(){
    [...modalBg].forEach((item, index) => {
        item.style.display = 'flex';
    });
}
async function buscarDatos(url, opciones = {}) {
    try {
        const response = await fetch(url, opciones);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const respuesta = await response.json();
        return respuesta;

    } catch (error) {
        console.error('There was an error:', error);
    }
}
async function cargarMaterias(semestrenum,cursoidnum){
    const url = route('cursos.materias', {cursoid:cursoidnum,semestre:semestrenum})

    try {
        const respuesta = await buscarDatos(url);
        ModalMateriaList.innerHTML = "";

        respuesta.forEach(materia => {
            const materiaA = document.createElement('a');
            materiaA.innerHTML = `<span>${materia.name}</span><i class="fa-solid fa-caret-right"></i>`;

            materiaA.addEventListener('click', async (event) => {
                event.preventDefault();

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const storeurl = route('cursomateria.store')
                    const postData = {
                        curso_id: cursoidnum,
                        materia_id: materia.id,
                        semestre: semestrenum
                    };

                    const responseData = await buscarDatos(storeurl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(postData),
                    });

                    window.location.href = route('cursos.show', { curso: cursoidnum });
                } catch (error) {
                    console.error('Error assigning materia:', error);
                    cerrarModal()
                }
            });

            ModalMateriaList.appendChild(materiaA);
        })

        abrirModal()

    } catch (error) {
        console.error("Failed to load materias in cargarMaterias:", error);
    }
}

function clearSelects(selectlists){
    selectlists.forEach((item, index) => {
        // if they options should not be deleted
        if (item[1]){
            const optionsArray = Array.from(item[0].options);
            optionsArray.forEach(option => {
                if(option.index !== 0){
                    option.remove()
                }
            });
        }
        // reset it
        item[0].selectedIndex = 0;
    });
}
async function GM_cargarSemestres(selectedCurso){
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = route('cursos.semestres',{cursoid:selectedCurso});

        const responseData = await buscarDatos(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
        });

        if(responseData){
            for (let i = 1; i <= responseData.semestres; i++){
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Semestre ${i}`;
                GMSemestreSelect.appendChild(option);
            }
        }
    } catch (error) {
        console.error('Error getting semestres:', error);
    }
}
async function GM_cargarMaterias(selectedCurso,selectedSemestre){
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = route('cursos.materiascompletas',{cursoid:selectedCurso,semestre:selectedSemestre});

        const responseData = await buscarDatos(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
        });

        if(responseData){
            responseData.forEach((item,index) => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name;
                GMMateriaSelect.appendChild(option);
            })
        }
    } catch (error) {
        console.error('Error getting materias:', error);
    }
}
async function GE_cargarSemestres(selectedCurso){
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = route('cursos.semestres',{cursoid:selectedCurso});

        const responseData = await buscarDatos(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
        });

        if(responseData){
            for (let i = 1; i <= responseData.semestres; i++){
                const option = document.createElement('option');
                option.value = i;
                option.textContent = `Semestre ${i}`;
                GESemestreSelect.appendChild(option);
            }
        }
    } catch (error) {
        console.error('Error getting semestres:', error);
    }
}

// -----
if (ModalMateriaCerrarBtn){
    ModalMateriaCerrarBtn.addEventListener('click', cerrarModal);
}
[...VerMateriasBtn].forEach((item, index) => {
    item.addEventListener('click', function() {
        cargarMaterias(item.dataset.semestre,item.dataset.curso)
    });
});
// -----
if (modalidadToggles){
    modalidadToggles.forEach(checkbox => {
        checkbox.addEventListener('change', async function() {
            const modalidad = this.dataset.modalidadId;
            const nuevoActivo = this.checked;

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const modalidadActivarurl = route('modalidad.custom',{customaction:"activar",modalidadid:modalidad});

                const responseData = await buscarDatos(modalidadActivarurl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({activo:nuevoActivo}),
                });
                if(!responseData){
                    this.checked = !nuevoActivo;
                }
            } catch (error) {
                console.error("Error changing modalidad state: ",error)
                this.checked = !nuevoActivo;
            }
        })
    })
}
// ---------
if (GMProfesorSelect){
    GMProfesorSelect.addEventListener('change',function(){
        clearSelects([
            [GMCursoSelect,false],
            [GMSemestreSelect,true],
            [GMMateriaSelect,true],
        ])
    })
}
if (GMCursoSelect){
    GMCursoSelect.addEventListener('change',function(){
        clearSelects([
            [GMSemestreSelect,true],
            [GMMateriaSelect,true],
        ])
        GM_cargarSemestres(GMCursoSelect.value);
    })
}
if (GMSemestreSelect){
    GMSemestreSelect.addEventListener('change',function(){
        clearSelects([
            [GMMateriaSelect,true],
        ])
        GM_cargarMaterias(GMCursoSelect.value,GMSemestreSelect.value);
    })
}
// ------
if (GECursoSelect){
    GECursoSelect.addEventListener('change',function(){
        clearSelects([
            [GESemestreSelect,true]
        ])
        GE_cargarSemestres(GECursoSelect.value);
    })
}

// -----
[...printButton].forEach((buttonitem,index) => {
    buttonitem.addEventListener('click',function(e){
        e.preventDefault();

        const printframeId = buttonitem.dataset.printFrame;
        const printframe = document.getElementById(printframeId);

        html2pdf(printframe, {
            margin: 10,
            filename: 'boleta.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        });
    })
});
[...enviarBoletaBoton].forEach((buttonitem,index) => {
    buttonitem.addEventListener('click',function(e){
        e.preventDefault();

        const printframeId = buttonitem.dataset.printFrame;
        const printframe = document.getElementById(printframeId);
        const correo = printframe.dataset.boletaUserId;

        html2pdf().from(printframe).outputPdf('datauristring').then( async function (pdfDataUri) {
            // pdfDataUri is a base64 encoded string (e.g., "data:application/pdf;base64,JVBERi...")
            // We need to extract just the base64 part
            const base64Pdf = pdfDataUri.split(',')[1];
            

            // Send the Base64 PDF data to your Laravel backend
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const emailurl = route('correo.enviarBoleta');

                const responseData = await buscarDatos(emailurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        pdf_data: base64Pdf,
                        correo: correo
                    })
                });
                if(responseData){
                    alert('PDF enviado por correo electrónico con éxito!');
                }
            } catch (error) {
                console.error("Error changing modalidad state: ",error)
                this.checked = !nuevoActivo;
            }
        });
    })
})