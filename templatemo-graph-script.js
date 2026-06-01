/* JavaScript Document

TemplateMo 602 Graph Page

https://templatemo.com/tm-602-graph-page

*/

// Hamburger menu toggle
const hamburger = document.getElementById('hamburger');
const navLinksMobile = document.getElementById('navLinksMobile');
const mobileLinks = navLinksMobile.querySelectorAll('a');

hamburger.addEventListener('click', function () {
   hamburger.classList.toggle('active');
   navLinksMobile.classList.toggle('active');
});

// Close mobile menu when a link is clicked
mobileLinks.forEach(link => {
   link.addEventListener('click', function () {
      hamburger.classList.remove('active');
      navLinksMobile.classList.remove('active');
   });
});

// Close mobile menu when scrolling
window.addEventListener('scroll', function () {
   hamburger.classList.remove('active');
   navLinksMobile.classList.remove('active');
});

// Navbar scroll effect
window.addEventListener('scroll', function () {
   const navbar = document.getElementById('navbar');
   if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
   } else {
      navbar.classList.remove('scrolled');
   }
});

// Active navigation highlighting
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-links a');
const mobileNavLinks = document.querySelectorAll('.nav-links-mobile a');

function updateActiveNav() {
   const scrollY = window.pageYOffset;

   sections.forEach(section => {
      const sectionHeight = section.offsetHeight;
      const sectionTop = section.offsetTop - 100;
      const sectionId = section.getAttribute('id');

      if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
         navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${sectionId}`) {
               link.classList.add('active');
            }
         });

         mobileNavLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${sectionId}`) {
               link.classList.add('active');
            }
         });
      }
   });
}

window.addEventListener('scroll', updateActiveNav);

// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
   anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
         target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
         });
      }
   });
});

// Mini charts animation - IMPROVED VERSION
function drawMiniChart(canvasId, color) {
   const canvas = document.getElementById(canvasId);
   if (!canvas) {
      console.error('Canvas not found:', canvasId);
      return;
   }

   const ctx = canvas.getContext('2d');
   
   // Pastikan canvas memiliki dimensi yang tepat
   canvas.width = canvas.offsetWidth || 200;
   canvas.height = canvas.offsetHeight || 60;
   
   // Jika canvas masih 0x0, set default
   if (canvas.width === 0) canvas.width = 200;
   if (canvas.height === 0) canvas.height = 60;

   // Generate random data points
   const points = [];
   for (let i = 0; i < 10; i++) {
      points.push(Math.random() * canvas.height * 0.8 + canvas.height * 0.1);
   }

   // Clear canvas
   ctx.clearRect(0, 0, canvas.width, canvas.height);

   // Draw line
   ctx.beginPath();
   ctx.strokeStyle = color;
   ctx.lineWidth = 2;

   points.forEach((point, index) => {
      const x = (canvas.width / (points.length - 1)) * index;
      const y = point;

      if (index === 0) {
         ctx.moveTo(x, y);
      } else {
         ctx.lineTo(x, y);
      }
   });

   ctx.stroke();

   // Draw gradient fill
   const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
   gradient.addColorStop(0, color.replace(')', ', 0.3)').replace('rgb', 'rgba'));
   gradient.addColorStop(1, color.replace(')', ', 0)').replace('rgb', 'rgba'));

   ctx.lineTo(canvas.width, canvas.height);
   ctx.lineTo(0, canvas.height);
   ctx.closePath();
   ctx.fillStyle = gradient;
   ctx.fill();
}

// Initialize mini charts - WAIT FOR FULL PAGE LOAD
function initializeCharts() {
   setTimeout(() => {
      drawMiniChart('miniChart1', '#00ffcc');
      drawMiniChart('miniChart2', '#ff0080');
      drawMiniChart('miniChart3', '#00ccff');
      drawMiniChart('miniChart4', '#ffcc00');
      drawMiniChart('miniChart5', '#ff6b6b');
      drawMiniChart('miniChart6', '#4ecdc4');
      drawMiniChart('miniChart7', '#1cff15');
   }, 500);
}

// Initialize when page is fully loaded
window.addEventListener('load', initializeCharts);
// Also initialize when DOM is ready (fallback)
document.addEventListener('DOMContentLoaded', initializeCharts);
// Re-draw charts on resize
window.addEventListener('resize', initializeCharts);

// Animate stats on scroll
const observerOptions = {
   threshold: 0.5,
   rootMargin: '0px'
};

const observer = new IntersectionObserver((entries) => {
   entries.forEach(entry => {
      if (entry.isIntersecting) {
         const bars = entry.target.querySelectorAll('.bar');
         bars.forEach((bar, index) => {
            setTimeout(() => {
               bar.style.animation = 'slideUp 0.5s ease-out forwards';
            }, index * 100);
         });
      }
   });
}, observerOptions);

document.querySelectorAll('.bar-chart').forEach(chart => {
   observer.observe(chart);
});

// Add slide up animation
const style = document.createElement('style');
style.textContent = `
            @keyframes slideUp {
                from {
                    transform: scaleY(0);
                    transform-origin: bottom;
                }
                to {
                    transform: scaleY(1);
                    transform-origin: bottom;
                }
            }
        `;
document.head.appendChild(style);

// Chart options interaction
document.querySelectorAll('.chart-options').forEach(optionGroup => {
   const options = optionGroup.querySelectorAll('.chart-option');
   options.forEach(option => {
      option.addEventListener('click', function () {
         options.forEach(opt => opt.classList.remove('active'));
         this.classList.add('active');
      });
   });
});

// Form submission handler
const contactForm = document.getElementById('contactForm');
if (contactForm) {
   contactForm.addEventListener('submit', function (e) {
      e.preventDefault();

      // Get form data
      const formData = {
         name: document.getElementById('name').value,
         email: document.getElementById('email').value,
         subject: document.getElementById('subject').value,
         message: document.getElementById('message').value
      };

      // Show success message
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Message Sent! ✓';
      submitBtn.style.background = 'linear-gradient(135deg, #4ade80, #22c55e)';

      // Reset form
      this.reset();

      // Reset button after 3 seconds
      setTimeout(() => {
         submitBtn.textContent = originalText;
         submitBtn.style.background = 'linear-gradient(135deg, #ff6b6b, #ff8e53)';
      }, 3000);
   });
}

// Add hover effect to contact form inputs
const contactFormInputs = document.querySelectorAll('#contactForm input, #contactForm textarea');
if (contactFormInputs.length > 0) {
   contactFormInputs.forEach(input => {
      input.addEventListener('focus', function () {
         this.style.borderColor = 'rgba(0, 255, 204, 0.5)';
         this.style.background = 'rgba(255, 255, 255, 0.08)';
         this.style.boxShadow = '0 0 20px rgba(0, 255, 204, 0.1)';
      });

      input.addEventListener('blur', function () {
         this.style.borderColor = 'rgba(255, 255, 255, 0.1)';
         this.style.background = 'rgba(255, 255, 255, 0.05)';
         this.style.boxShadow = 'none';
      });
   });
}

// Metrics animation on scroll
const metricsObserver = new IntersectionObserver((entries) => {
   entries.forEach(entry => {
      if (entry.isIntersecting) {
         const metrics = entry.target.querySelectorAll('.metric-item');
         metrics.forEach((metric, index) => {
            setTimeout(() => {
               metric.style.transform = 'translateY(0)';
               metric.style.opacity = '1';
            }, index * 100);
         });
      }
   });
}, {
   threshold: 0.3
});

document.querySelectorAll('.metrics-grid').forEach(grid => {
   metricsObserver.observe(grid);
});

// Initialize metrics animation state
document.querySelectorAll('.metric-item').forEach(item => {
   item.style.transform = 'translateY(20px)';
   item.style.opacity = '0';
   item.style.transition = 'all 0.5s ease';
});

// ===== ALUMNI TABLE CRUD FUNCTIONALITY =====

// Modal Management
const modalAlumni = document.getElementById('modalAlumni');
const modalDelete = document.getElementById('modalDelete');
const closeButtons = document.querySelectorAll('.close-modal');
const btnTambahAlumni = document.getElementById('btnTambahAlumni');
const formAlumni = document.getElementById('formAlumni');
const confirmDelete = document.getElementById('confirmDelete');

let currentDeleteId = null;
let alumniData = [
    {
        id: 1,
        nama: "Andi Wijaya",
        nim: "2010114001",
        tahun_lulus: "2022",
        program_studi: "Teknik Informatika",
        asal_universitas: "Universitas Teknologi",
        pekerjaan: "Software Engineer",
        instansi: "Google Indonesia",
        tanggal_lahir: "1999-05-15"
    },
    {
        id: 2,
        nama: "Budi Santoso",
        nim: "2010114002",
        tahun_lulus: "2021",
        program_studi: "Teknik Sipil",
        asal_universitas: "Universitas Negeri",
        pekerjaan: "Site Engineer",
        instansi: "PT Jaya Konstruksi",
        tanggal_lahir: "1998-08-22"
    }
    // Add more dummy data as needed
];

// Open modal for adding alumni
btnTambahAlumni.addEventListener('click', () => {
    document.getElementById('modalTitle').textContent = 'Tambah Data Alumni';
    formAlumni.reset();
    document.getElementById('alumniId').value = '';
    modalAlumni.style.display = 'flex';
});

// Close modals
closeButtons.forEach(button => {
    button.addEventListener('click', () => {
        modalAlumni.style.display = 'none';
        modalDelete.style.display = 'none';
    });
});

// Close modal when clicking outside
window.addEventListener('click', (event) => {
    if (event.target === modalAlumni) {
        modalAlumni.style.display = 'none';
    }
    if (event.target === modalDelete) {
        modalDelete.style.display = 'none';
    }
});

// Form submission
formAlumni.addEventListener('submit', (e) => {
    e.preventDefault();
    
    const formData = {
        id: document.getElementById('alumniId').value,
        nama: document.getElementById('nama').value,
        nim: document.getElementById('nim').value,
        tahun_lulus: document.getElementById('tahun_lulus').value,
        program_studi: document.getElementById('program_studi').value,
        asal_universitas: document.getElementById('asal_universitas').value,
        pekerjaan: document.getElementById('pekerjaan').value,
        instansi: document.getElementById('instansi').value,
        tanggal_lahir: document.getElementById('tanggal_lahir').value
    };
    
    if (formData.id) {
        // Edit existing alumni
        const index = alumniData.findIndex(item => item.id == formData.id);
        if (index !== -1) {
            alumniData[index] = { ...alumniData[index], ...formData };
        }
    } else {
        // Add new alumni
        formData.id = alumniData.length > 0 ? Math.max(...alumniData.map(item => item.id)) + 1 : 1;
        alumniData.push(formData);
    }
    
    updateTable();
    modalAlumni.style.display = 'none';
    showNotification('Data alumni berhasil disimpan!');
});

// Edit alumni function
window.editAlumni = function(id) {
    const alumni = alumniData.find(item => item.id == id);
    if (alumni) {
        document.getElementById('modalTitle').textContent = 'Edit Data Alumni';
        document.getElementById('alumniId').value = alumni.id;
        document.getElementById('nama').value = alumni.nama;
        document.getElementById('nim').value = alumni.nim;
        document.getElementById('tahun_lulus').value = alumni.tahun_lulus;
        document.getElementById('program_studi').value = alumni.program_studi;
        document.getElementById('asal_universitas').value = alumni.asal_universitas;
        document.getElementById('pekerjaan').value = alumni.pekerjaan || '';
        document.getElementById('instansi').value = alumni.instansi || '';
        document.getElementById('tanggal_lahir').value = alumni.tanggal_lahir;
        modalAlumni.style.display = 'flex';
    }
};

// Delete alumni function
window.deleteAlumni = function(id) {
    const alumni = alumniData.find(item => item.id == id);
    if (alumni) {
        currentDeleteId = id;
        document.getElementById('deleteAlumniName').textContent = alumni.nama;
        modalDelete.style.display = 'flex';
    }
};

// Confirm delete
if (confirmDelete) {
    confirmDelete.addEventListener('click', () => {
        if (currentDeleteId) {
            alumniData = alumniData.filter(item => item.id != currentDeleteId);
            updateTable();
            modalDelete.style.display = 'none';
            showNotification('Data alumni berhasil dihapus!');
            currentDeleteId = null;
        }
    });
}

// Search and filter functionality
const searchInput = document.getElementById('searchAlumni');
const filterTahun = document.getElementById('filterTahun');
const filterProdi = document.getElementById('filterProdi');
const btnResetFilter = document.getElementById('btnResetFilter');

function filterTable() {
    const searchTerm = searchInput.value.toLowerCase();
    const tahunFilter = filterTahun.value;
    const prodiFilter = filterProdi.value;
    
    const filteredData = alumniData.filter(item => {
        const matchesSearch = 
            item.nama.toLowerCase().includes(searchTerm) ||
            item.nim.toLowerCase().includes(searchTerm) ||
            item.program_studi.toLowerCase().includes(searchTerm);
        
        const matchesTahun = !tahunFilter || item.tahun_lulus == tahunFilter;
        const matchesProdi = !prodiFilter || item.program_studi == prodiFilter;
        
        return matchesSearch && matchesTahun && matchesProdi;
    });
    
    renderTable(filteredData);
}

if (searchInput) searchInput.addEventListener('input', filterTable);
if (filterTahun) filterTahun.addEventListener('change', filterTable);
if (filterProdi) filterProdi.addEventListener('change', filterTable);
if (btnResetFilter) {
    btnResetFilter.addEventListener('click', () => {
        searchInput.value = '';
        filterTahun.value = '';
        filterProdi.value = '';
        filterTable();
    });
}

// Render table function - UPDATED VERSION
function renderTable(data) {
    const tableBody = document.getElementById('alumniTableBody');
    if (!tableBody) return;
    
    tableBody.innerHTML = '';
    
    data.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="text-center">${index + 1}</td>
            <td class="text-nowrap">${item.nama}</td>
            <td>${item.nim}</td>
            <td class="text-center">${item.tahun_lulus}</td>
            <td>${item.program_studi}</td>
            <td>${item.asal_universitas}</td>
            <td>${item.pekerjaan || '-'}</td>
            <td>${item.instansi || '-'}</td>
            <td class="text-center">${item.tanggal_lahir}</td>
            <td class="text-center action-buttons">
                <button class="btn-edit" onclick="editAlumni(${item.id})" title="Edit">✏️</button>
                <button class="btn-delete" onclick="deleteAlumni(${item.id})" title="Hapus">🗑️</button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Update table function
function updateTable() {
    renderTable(alumniData);
}

// Show notification
function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #00ffcc, #00ccff);
        color: #0a0e27;
        padding: 15px 25px;
        border-radius: 10px;
        font-weight: 600;
        z-index: 3000;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add animation styles for notification
const notificationStyle = document.createElement('style');
notificationStyle.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(notificationStyle);

// Initialize table on load
document.addEventListener('DOMContentLoaded', () => {
    updateTable();
});

