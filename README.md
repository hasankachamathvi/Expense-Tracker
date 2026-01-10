# 💰 Expense Tracker

A simple and clean web application to track your daily expenses with monthly summaries and category-wise breakdowns.

## 🚀 Features

- **Add Daily Expenses**: Quickly add expenses with amount, category, description, and date
- **View Expenses by Date**: Filter and view expenses for specific dates
- **Monthly Summary**: Get total spending and category-wise breakdown for any month
- **Simple & Clean UI**: Modern, responsive design with gradient styling
- **Delete Expenses**: Remove expenses you no longer need to track

## 🛠️ Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+

## 📋 Categories

The app supports the following expense categories:
- 🍔 Food
- 🚗 Transport
- 🛍️ Shopping
- 🎬 Entertainment
- 📄 Bills
- 🏥 Healthcare
- 📚 Education
- 📌 Other

## 📦 Installation

### Prerequisites
- XAMPP, WAMP, or LAMP server
- PHP 7.4 or higher
- MySQL 5.7 or higher

### Setup Steps

1. **Clone or Download** this project to your local machine

2. **Move to Web Server Directory**
   - For XAMPP: Move to `C:\xampp\htdocs\expense-tracker`
   - For WAMP: Move to `C:\wamp64\www\expense-tracker`

3. **Setup Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Import the SQL file: `database/setup.sql`
   - Or manually run the SQL commands from the file

4. **Configure Database Connection**
   - Open `php/config.php`
   - Update the database credentials if needed:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'expense_tracker');
     ```

5. **Start Your Server**
   - Start Apache and MySQL from XAMPP/WAMP control panel

6. **Access the Application**
   - Open your browser and go to: `http://localhost/expense-tracker`

## 📁 Project Structure

```
expense-tracker/
│
├── index.html              # Main HTML file
├── css/
│   └── style.css          # All styles
├── js/
│   └── script.js          # Frontend JavaScript
├── php/
│   ├── config.php         # Database configuration
│   ├── add_expense.php    # Add expense API
│   ├── get_expenses.php   # Get expenses API
│   ├── delete_expense.php # Delete expense API
│   └── get_summary.php    # Monthly summary API
├── database/
│   └── setup.sql          # Database setup script
└── README.md              # Documentation
```

## 🎯 Usage

### Adding an Expense
1. Fill in the amount, select a category, add description, and choose a date
2. Click "Add Expense" button
3. The expense will be saved and displayed in the expenses list

### Viewing Expenses
- By default, all recent expenses are shown
- Use the date filter to view expenses for a specific date
- Click "Show All" to see all expenses again

### Monthly Summary
1. Select a month from the month picker
2. Click "Get Summary"
3. View total spending and category-wise breakdown

### Deleting an Expense
- Click the "Delete" button next to any expense
- Confirm the deletion

## 🔒 Security Notes

For production use, consider:
- Use prepared statements (already implemented)
- Add user authentication
- Implement CSRF protection
- Use HTTPS
- Validate and sanitize all inputs
- Set proper database user permissions

## 🎨 Customization

You can easily customize:
- **Colors**: Edit the gradient colors in `css/style.css`
- **Categories**: Add/modify categories in `index.html` and update the emoji icons
- **Currency**: Change ₹ to your local currency symbol

## 📱 Responsive Design

The application is fully responsive and works on:
- Desktop computers
- Tablets
- Mobile phones

## 🐛 Troubleshooting

**Database Connection Error**
- Make sure MySQL is running
- Check database credentials in `php/config.php`
- Verify database exists

**Expenses Not Showing**
- Check browser console for errors
- Ensure all PHP files are in the correct location
- Verify database tables are created properly

**Date Issues**
- Make sure your system date is correct
- Check PHP timezone settings

## 📄 License

This project is open source and available for personal and educational use.

## 👨‍💻 Author

Created with ❤️ for expense tracking

## 🤝 Contributing

Feel free to fork this project and make improvements!

---

Happy Expense Tracking! 💰📊
