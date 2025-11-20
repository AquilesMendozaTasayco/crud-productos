import Swal from "sweetalert2";
import { currentPage, pageSize } from "./state.js";

export function showAlert(message, type = "success") {
  Swal.fire({
    icon: type,
    title: message,
    timer: 1600,
    showConfirmButton: false,
    toast: true,
    position: "top-end",
  });
}

export function showSkeleton(tbody, emptyState) {
  tbody.innerHTML = "";
  emptyState.classList.add("hidden");

  for (let i = 0; i < 3; i++) {
    const tr = document.createElement("tr");
    tr.className = "animate-pulse";
    tr.innerHTML = `
      <td class="px-4 py-3"><div class="h-3 bg-gray-200 rounded w-8"></div></td>
      <td class="px-4 py-3"><div class="h-3 bg-gray-200 rounded w-32"></div></td>
      <td class="px-4 py-3"><div class="h-3 bg-gray-200 rounded w-16"></div></td>
      <td class="px-4 py-3"><div class="h-3 bg-gray-200 rounded w-40"></div></td>
      <td class="px-4 py-3 text-center"><div class="h-3 bg-gray-200 rounded w-20 mx-auto"></div></td>
    `;
    tbody.appendChild(tr);
  }
}

export function renderTable(pageItems, tbody, emptyState) {
  tbody.innerHTML = "";

  if (pageItems.length === 0) {
    emptyState.classList.remove("hidden");
    return;
  }

  emptyState.classList.add("hidden");

  pageItems.forEach((p) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td class="px-6 py-3">${p.id}</td>
      <td class="px-6 py-3">${p.name}</td>
      <td class="px-6 py-3">S/ ${p.price}</td>
      <td class="px-6 py-3">${p.description ?? ""}</td>
      <td class="px-6 py-3">
        <div class="flex items-center justify-center gap-3">
          <button data-id="${p.id}"
            class="edit-btn text-yellow-600 hover:text-yellow-700 transition"
            aria-label="Editar producto">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 3.487a2.13 2.13 0 113.012 3.012l-9.75 9.75-4.012 1 1-4.012 9.75-9.75z" />
            </svg>
          </button>

          <button data-id="${p.id}"
            class="delete-btn text-red-600 hover:text-red-700 transition"
            aria-label="Eliminar producto">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a2 2 0 012-2h3a2 2 0 012 2m-7 0h10" />
            </svg>
          </button>
          
        </div>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

export function updatePagination(total, pagination, currentPageEl, lastPageEl, prevBtn, nextBtn) {
  const lastPage = Math.max(1, Math.ceil(total / pageSize));

  pagination.classList.toggle("hidden", total === 0);

  currentPageEl.textContent = currentPage;
  lastPageEl.textContent = lastPage;

  prevBtn.disabled = currentPage === 1;
  nextBtn.disabled = currentPage === lastPage;

  return lastPage;
}

export function openModal(modal, modalContent) {
  modal.classList.remove("hidden");
  requestAnimationFrame(() => {
    modalContent.classList.remove("opacity-0", "scale-95");
    modalContent.classList.add("opacity-100", "scale-100");
  });
}

export function closeModal(modal, modalContent, form, idField, modalTitle) {
  modalContent.classList.remove("opacity-100", "scale-100");
  modalContent.classList.add("opacity-0", "scale-95");

  setTimeout(() => {
    modal.classList.add("hidden");
    form.reset();
    idField.value = "";
    modalTitle.textContent = "Nuevo Producto";
  }, 200);
}
