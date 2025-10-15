// JavaScript customizado para o sistema MVC com Tailwind CSS

document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss flash messages após 5 segundos
    const flashMessages = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"], [class*="bg-blue-50"]');
    flashMessages.forEach(function(message) {
        setTimeout(function() {
            if (message && message.parentNode) {
                message.style.transition = 'opacity 0.5s ease-out';
                message.style.opacity = '0';
                setTimeout(function() {
                    if (message.parentNode) {
                        message.parentNode.removeChild(message);
                    }
                }, 500);
            }
        }, 5000);
    });

    // Confirmação para ações de deletar
    const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Tem certeza que deseja executar esta ação?')) {
                e.preventDefault();
            }
        });
    });

    // Validação de formulários
    const forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    field.classList.remove('border-gray-300');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                    field.classList.add('border-gray-300');
                }
            });

            // Validação de email
            const emailFields = form.querySelectorAll('input[type="email"]');
            emailFields.forEach(function(field) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (field.value && !emailRegex.test(field.value)) {
                    field.classList.add('border-red-500');
                    field.classList.remove('border-gray-300');
                    isValid = false;
                } else if (field.value) {
                    field.classList.remove('border-red-500');
                    field.classList.add('border-gray-300');
                }
            });

            // Validação de confirmação de senha
            const passwordFields = form.querySelectorAll('input[name="password"]');
            const confirmPasswordFields = form.querySelectorAll('input[name="password_confirm"]');
            
            if (passwordFields.length > 0 && confirmPasswordFields.length > 0) {
                const password = passwordFields[0].value;
                const confirmPassword = confirmPasswordFields[0].value;
                
                if (password && confirmPassword && password !== confirmPassword) {
                    confirmPasswordFields[0].classList.add('border-red-500');
                    confirmPasswordFields[0].classList.remove('border-gray-300');
                    isValid = false;
                } else if (confirmPassword) {
                    confirmPasswordFields[0].classList.remove('border-red-500');
                    confirmPasswordFields[0].classList.add('border-gray-300');
                }
            }

            if (!isValid) {
                e.preventDefault();
                showAlert('Por favor, corrija os erros no formulário.', 'error');
            }
        });
    });

    // Remover classes de erro quando o usuário começar a digitar
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.classList.remove('border-red-500');
            if (!this.classList.contains('border-blue-500')) {
                this.classList.add('border-gray-300');
            }
        });
        
        // Adicionar foco visual
        input.addEventListener('focus', function() {
            this.classList.remove('border-gray-300');
            this.classList.add('border-blue-500');
        });
        
        input.addEventListener('blur', function() {
            if (!this.classList.contains('border-red-500')) {
                this.classList.remove('border-blue-500');
                this.classList.add('border-gray-300');
            }
        });
    });
});

// Função para mostrar alertas
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 
                   type === 'error' ? 'bg-red-50 border-red-200 text-red-800' : 
                   'bg-blue-50 border-blue-200 text-blue-800';
    
    alertDiv.className = `mb-4 p-4 rounded-md border ${bgColor} fixed top-4 right-4 z-50 max-w-sm`;
    alertDiv.innerHTML = `
        <div class="flex justify-between items-center">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 ml-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    `;
    
    // Adicionar ao body para aparecer sobre o modal
    document.body.appendChild(alertDiv);
    
    // Auto-dismiss após 3 segundos
    setTimeout(function() {
        if (alertDiv.parentNode) {
            alertDiv.style.transition = 'opacity 0.5s ease-out';
            alertDiv.style.opacity = '0';
            setTimeout(function() {
                if (alertDiv.parentNode) {
                    alertDiv.parentNode.removeChild(alertDiv);
                }
            }, 500);
        }
    }, 3000);
}

// Função para confirmar ações
function confirmAction(message = 'Tem certeza que deseja executar esta ação?') {
    return confirm(message);
}

// Função para animar elementos ao entrar na tela
function animateOnScroll() {
    const elements = document.querySelectorAll('.animate-on-scroll');
    elements.forEach(function(element) {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;
        
        if (elementTop < window.innerHeight - elementVisible) {
            element.classList.add('animate-fade-in');
        }
    });
}

// Adicionar animação de scroll se houver elementos
if (document.querySelectorAll('.animate-on-scroll').length > 0) {
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Executar uma vez no carregamento
}
