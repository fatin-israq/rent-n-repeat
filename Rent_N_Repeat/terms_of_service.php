<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions - Rent N Repeat</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .terms-container {
            padding: 40px;
            background-color: #f8f9fa;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
            color: #007bff;
        }

        h2 {
            font-size: 1.75rem;
            margin-top: 30px;
        }

        p,
        ul {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        ul {
            padding-left: 20px;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            padding: 20px;
            background-color: #343a40;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>

    <div class="terms-container container">
        <h1>Terms and Conditions</h1>

        <h2>1. Introduction</h2>
        <p>Welcome to <a href="index.php" style="color: black;">Rent N Repeat</a>. By using this Website, you agree to comply with and be bound by the following Terms and Conditions. These govern your access to and use of the Website, whether you are renting out clothing items or renting them for an occasion. Please read these Terms carefully.</p>

        <h2>2. Definitions</h2>
        <ul>
            <li><strong>lessee:</strong> A user who rents out their clothing items via the Website.</li>
            <li><strong>lessor:</strong> A user who rents clothing items from another user via the Website.</li>
            <li><strong>Item(s):</strong> The clothing or accessories made available for rent on the Website.</li>
            <li><strong>Rental Price:</strong> The amount the lessor pays to rent the Item(s).</li>
        </ul>

        <h2>3. Eligibility</h2>
        <p>You must be at least 18 years old to use the Website. By registering an account, you confirm that the information provided is accurate and that you agree to these Terms.</p>

        <h2>4. Account Registration</h2>
        <p>All users must register an account to participate in renting or listing Items on the Website. You are responsible for maintaining the confidentiality of your login information and for all activities under your account.</p>

        <h2>5. Renting and Listing Items</h2>
        <ul>
            <li><strong>lessee:</strong> When listing an Item for rent, you must provide accurate descriptions, high-quality photos, and any specific conditions regarding the rental. You must own the Item and ensure it is in good condition.</li>
            <li><strong>lessor:</strong> When renting an Item, you agree to use it solely for its intended purpose, return it in the same condition, and abide by any specific conditions set by the lessee.</li>
        </ul>

        <h2>6. Payment and Fees</h2>
        <ul>
            <li>The lessee sets the Rental Price for each Item.</li>
            <li>Rent N Repeat will retain 20% of the Rental Price as a service fee for hosting the transaction.</li>
            <li>The remaining 80% of the Rental Price will be transferred to the lessee after successful completion of the rental period.</li>
            <li>All payments will be processed through the payment gateways integrated into the Website. Any applicable taxes are the responsibility of the user.</li>
        </ul>

        <h2>7. Damage and Responsibility</h2>
        <ul>
            <li><strong>lessor Responsibility:</strong> The lessor agrees to take full responsibility for the care and condition of the rented Item. If an Item is returned with any damage beyond normal wear and tear, the lessor will be liable for the cost of repair or replacement as determined by the lessee.</li>
            <li><strong>Dispute Resolution:</strong> In the event of a dispute over damages, Rent N Repeat reserves the right to mediate, but final responsibility rests with the parties involved.</li>
        </ul>

        <h2>8. Return and Late Fees</h2>
        <p>Items must be returned on the agreed-upon date. Failure to return the Item on time may result in additional late fees, which will be 5% of the rental cost per day for each additional hour. Rent N Repeat will not retain any percentage from late fees; this will entirely be the lessee's emolument.</p>

        <h2>9. Reviews and Ratings</h2>
        <p>Only users who have completed a rental transaction (either as a lessee or a lessor) are eligible to leave a review or rating for an Item. Reviews must be honest and reflect the actual experience of renting the Item. Rent N Repeat reserves the right to remove or moderate reviews that violate community standards or are found to be false or misleading.</p>

        <h2>10. Cancellation Policy</h2>
        <ul>
            <li><strong>lessee Cancellation:</strong> The lessee may cancel a rental agreement before the Item has been picked up or shipped. Any payments already made will be refunded to the lessor.</li>
            <li><strong>lessor Cancellation:</strong> The lessor may cancel their rental request before receiving the Item, subject to any cancellation fees imposed by the lessee.</li>
        </ul>

        <h2>11. Prohibited Activities</h2>
        <ul>
            <li>Renting or listing counterfeit or stolen Items.</li>
            <li>Misrepresenting an Item’s condition.</li>
            <li>Abusing the Website’s review or rating system.</li>
        </ul>

        <h2>12. Termination</h2>
        <p>Rent N Repeat reserves the right to terminate or suspend your account at its discretion if you violate any of these Terms or engage in fraudulent or harmful behavior.</p>

        <h2>13. Liability</h2>
        <ul>
            <li>Rent N Repeat is not responsible for the condition, authenticity, or legality of Items rented or listed by users.</li>
            <li>The Website acts as a facilitator and is not liable for any disputes or issues that arise between lessees and lessors.</li>
        </ul>

        <h2>14. Changes to Terms</h2>
        <p>Rent N Repeat may modify these Terms at any time. You will be notified of any significant changes, and continued use of the Website constitutes acceptance of the updated Terms.</p>

        <h2>15. Contact Information</h2>
        <p>For any questions or concerns regarding these Terms, please contact us at <a href="mailto:support@rentnrepeat.com">support@rentnrepeat.com</a>.</p>
    </div>

    <!-- Footer -->
    <?php include('footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>