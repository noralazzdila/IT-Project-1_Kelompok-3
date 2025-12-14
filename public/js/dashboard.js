function getRoleCard(title, route) {
    return `
        <div class="role-card" onclick="window.location='${route}'" style="cursor:pointer;">
            <div class="role-title">${title}</div>
            <div class="role-sub">Teknologi Informasi</div>
        </div>
    `;
}

function showRoles(module) {
    if (module !== 'sim-akademik') {
        return;
    }

    const roleContainer = document.getElementById('role-container');
    const user = JSON.parse(document.body.dataset.user);
    
    const roleMapping = {
        'mahasiswa': { title: 'Mahasiswa', route: routes.dashboardMahasiswa },
        'koor_pkl': { title: 'Koordinator PKL', route: routes.koorDashboard },
        'dosen': { title: 'Dosen', route: routes.dosenDashboard },
        'staf': { title: 'Staf', route: routes.stafIndex },
        'koor_prodi': { title: 'Koordinator Prodi', route: routes.koorprodiIndex },
    };

    let rolesHtml = '<h5 class="fw-bold mb-3">Daftar Role - SIM PKL</h5>';

    const userRole = user.role;

    if (roleMapping[userRole]) {
        if (user.is_validated || ['mahasiswa', 'koor_pkl'].includes(userRole)) {
             rolesHtml += getRoleCard(roleMapping[userRole].title, roleMapping[userRole].route);
        }
    }
    
    roleContainer.innerHTML = rolesHtml;
}

document.addEventListener('DOMContentLoaded', function() {
    const user = JSON.parse(document.body.dataset.user);
    const simPklCard = Array.from(document.querySelectorAll('.modul-card h6.fw-semibold'))
                            .find(el => el.textContent.trim() === 'SIM PKL');

    if (simPklCard) {
        simPklCard.parentElement.addEventListener('click', () => showRoles('sim-akademik'));
    }

    if (user.role !== 'mahasiswa') {
        showRoles('sim-akademik');
    }
});