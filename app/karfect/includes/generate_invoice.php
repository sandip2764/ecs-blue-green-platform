<?php
function generateInvoice($order_details, $user_details, $order_items) {
    $order_id = $order_details['order_id'];
    $order_date = date('F j, Y', strtotime($order_details['created_at']));
    $subtotal = $order_details['total_amount'] / 1.18; // Remove GST to get subtotal
    $gst = $order_details['total_amount'] - $subtotal;
    $total = $order_details['total_amount'];
    $delivery_address = $order_details['address'];
    $user_name = $user_details['name'];
    $user_email = $user_details['email'];

    // Escape special characters for LaTeX
    $order_id = str_replace(['&', '%', '$', '#', '_', '{', '}'], ['\&', '\%', '\$', '\#', '\_', '\{', '\}'], $order_id);
    $user_name = str_replace(['&', '%', '$', '#', '_', '{', '}'], ['\&', '\%', '\$', '\#', '\_', '\{', '\}'], $user_name);
    $user_email = str_replace(['&', '%', '$', '#', '_', '{', '}'], ['\&', '\%', '\$', '\#', '\_', '\{', '\}'], $user_email);
    $delivery_address = str_replace(['&', '%', '$', '#', '_', '{', '}'], ['\&', '\%', '\$', '\#', '\_', '\{', '\}'], $delivery_address);

    $product_rows = '';
    foreach ($order_items as $item) {
        $total_price = $item['quantity'] * $item['unit_price'];
        $product_name = str_replace(['&', '%', '$', '#', '_', '{', '}'], ['\&', '\%', '\$', '\#', '\_', '\{', '\}'], $item['product_name']);
        $product_rows .= "
            {$product_name} & {$item['quantity']} & ₹{$item['unit_price']} & ₹{$total_price} \\\\ \\hline
        ";
    }

    $latex_content = "
    \\documentclass[a4paper,12pt]{article}
    \\usepackage{fontspec}
    \\usepackage{polyglossia}
    \\setmainlanguage{english}
    \\setotherlanguage{hindi}
    \\newfontfamily\\hindifont[Script=Devanagari]{Shobhika} % Changed from \\hindi to \\hindifont
    \\usepackage{geometry}
    \\geometry{left=1.5cm,right=1.5cm,top=2cm,bottom=2cm}
    \\usepackage{array}
    \\usepackage{booktabs}
    \\usepackage{fancyhdr}
    \\usepackage{lastpage}
    \\pagestyle{fancy}
    \\fancyhf{}
    \\fancyfoot[C]{Page \\thepage\\ of \\pageref{LastPage}}
    \\renewcommand{\\headrulewidth}{0pt}

    \\begin{document}

    % Header
    \\begin{center}
        \\textbf{\\Large Karfect Pvt. Ltd.} \\\\
        \\vspace{0.2cm}
        \\textbf{INVOICE} \\\\
        \\vspace{0.2cm}
        Invoice No: {$order_id} \\quad Date: {$order_date}
    \\end{center}

    \\vspace{1cm}

    % Customer Details
    \\begin{tabular}{@{}p{0.5\\textwidth} p{0.5\\textwidth}@{}}
        \\textbf{Billed To:} & \\textbf{Ship To:} \\\\
        {$user_name} & {$delivery_address} \\\\
        {$user_email} & \\\\
    \\end{tabular}

    \\vspace{1cm}

    % Product Table
    \\begin{center}
        \\begin{tabular}{|l|c|r|r|}
            \\hline
            \\textbf{Product} & \\textbf{Quantity} & \\textbf{Unit Price} & \\textbf{Total} \\\\ \\hline
            {$product_rows}
            \\multicolumn{3}{|r|}{\\textbf{Subtotal}} & ₹" . number_format($subtotal, 2) . " \\\\ \\hline
            \\multicolumn{3}{|r|}{\\textbf{GST (18\%)}} & ₹" . number_format($gst, 2) . " \\\\ \\hline
            \\multicolumn{3}{|r|}{\\textbf{Grand Total}} & ₹" . number_format($total, 2) . " \\\\ \\hline
        \\end{tabular}
    \\end{center}

    \\vspace{1cm}

    % Footer
    \\begin{center}
        \\textit{Thank you for your business!} \\\\
        \\vspace{0.5cm}
        For any queries, contact us at: support@karfect.com | +91-1234567890 \\\\
        © 2025 Karfect Pvt. Ltd.
    \\end{center}

    \\end{document}
    ";

    return [
        'content' => $latex_content,
        'filename' => "invoice_order_{$order_id}.pdf"
    ];
}
?>