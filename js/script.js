// Set today's date as default
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date').value = today;
    document.getElementById('filterDate').value = today;
    
    const currentMonth = new Date().toISOString().slice(0, 7);
    document.getElementById('monthYear').value = currentMonth;
    
    loadAllExpenses();
    loadMonthlySummary();
});

// Add Expense
document.getElementById('expenseForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('php/add_expense.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            showMessage('Expense added successfully!', 'success');
            this.reset();
            document.getElementById('date').value = new Date().toISOString().split('T')[0];
            loadAllExpenses();
            loadMonthlySummary();
        } else {
            showMessage('Error: ' + result.message, 'error');
        }
    } catch (error) {
        showMessage('Error adding expense: ' + error.message, 'error');
    }
});

// Load All Expenses
async function loadAllExpenses() {
    try {
        const response = await fetch('php/get_expenses.php');
        const result = await response.json();
        
        if (result.success) {
            displayExpenses(result.data);
        } else {
            showMessage('Error loading expenses', 'error');
        }
    } catch (error) {
        showMessage('Error: ' + error.message, 'error');
    }
}

// Filter by Date
async function filterByDate() {
    const date = document.getElementById('filterDate').value;
    
    if (!date) {
        showMessage('Please select a date', 'error');
        return;
    }
    
    try {
        const response = await fetch(`php/get_expenses.php?date=${date}`);
        const result = await response.json();
        
        if (result.success) {
            displayExpenses(result.data);
        } else {
            showMessage('Error filtering expenses', 'error');
        }
    } catch (error) {
        showMessage('Error: ' + error.message, 'error');
    }
}

// Display Expenses
function displayExpenses(expenses) {
    const expensesList = document.getElementById('expensesList');
    
    if (expenses.length === 0) {
        expensesList.innerHTML = '<div class="no-data">No expenses found</div>';
        return;
    }
    
    let html = '';
    expenses.forEach(expense => {
        html += `
            <div class="expense-item">
                <div class="expense-details">
                    <div class="expense-amount">RS.${parseFloat(expense.amount).toFixed(2)}</div>
                    <span class="expense-category">${expense.category}</span>
                    <div class="expense-description">${expense.description}</div>
                    <div class="expense-date">${formatDate(expense.date)}</div>
                </div>
                <button class="btn btn-delete" onclick="deleteExpense(${expense.id})">Delete</button>
            </div>
        `;
    });
    
    expensesList.innerHTML = html;
}

// Delete Expense
async function deleteExpense(id) {
    if (!confirm('Are you sure you want to delete this expense?')) {
        return;
    }
    
    try {
        const response = await fetch('php/delete_expense.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}`
        });
        
        const result = await response.json();
        
        if (result.success) {
            showMessage('Expense deleted successfully!', 'success');
            loadAllExpenses();
            loadMonthlySummary();
        } else {
            showMessage('Error deleting expense', 'error');
        }
    } catch (error) {
        showMessage('Error: ' + error.message, 'error');
    }
}

// Load Monthly Summary
async function loadMonthlySummary() {
    const monthYear = document.getElementById('monthYear').value;
    
    if (!monthYear) {
        return;
    }
    
    try {
        const response = await fetch(`php/get_summary.php?month=${monthYear}`);
        const result = await response.json();
        
        if (result.success) {
            displaySummary(result.data);
        } else {
            showMessage('Error loading summary', 'error');
        }
    } catch (error) {
        showMessage('Error: ' + error.message, 'error');
    }
}

// Display Summary
function displaySummary(data) {
    const summarySection = document.getElementById('monthlySummary');
    
    if (!data.total || data.total === '0.00') {
        summarySection.innerHTML = '<div class="no-data">No expenses for this month</div>';
        return;
    }
    
    let html = `
        <div class="total-expense">
            <h3>Total Spent</h3>
            <div class="amount">RS.${parseFloat(data.total).toFixed(2)}</div>
        </div>
    `;
    
    if (data.categories && data.categories.length > 0) {
        html += '<h3 style="margin-bottom: 15px;">Category Breakdown</h3>';
        html += '<div class="category-breakdown">';
        
        data.categories.forEach(cat => {
            html += `
                <div class="category-item">
                    <div class="category-name">${cat.category}</div>
                    <div class="category-amount">RS.${parseFloat(cat.total).toFixed(2)}</div>
                </div>
            `;
        });
        
        html += '</div>';
    }
    
    summarySection.innerHTML = html;
}

// Utility Functions
function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

function showMessage(message, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    messageDiv.textContent = message;
    
    const container = document.querySelector('.container');
    container.insertBefore(messageDiv, container.firstChild);
    
    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}
