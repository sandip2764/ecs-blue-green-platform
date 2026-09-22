<?php
// Increase PHP execution timeout
set_time_limit(120); // 120 seconds

// Start output buffering to catch any unwanted output
ob_start();

// Disable error reporting to prevent any errors/warnings from corrupting the PDF
error_reporting(0);
ini_set('display_errors', 0);

if (isset($_POST['latex_content']) && isset($_POST['filename'])) {
    $latex_content = $_POST['latex_content'];
    $filename = $_POST['filename'];

    // Define a LaTeX-compatible temporary directory
    $temp_dir = 'C:/xampp/htdocs/karfect/temp'; // Use project-specific temp directory
    if (!is_dir($temp_dir)) {
        mkdir($temp_dir, 0777, true); // Create directory if it doesn't exist
    }

    // Generate a LaTeX-compatible filename (no spaces, no special characters)
    $unique_id = str_replace(['.', ' '], '', microtime(true)); // Use microtime for uniqueness
    $tex_file = $temp_dir . DIRECTORY_SEPARATOR . 'invoice_' . $unique_id . '.tex';
    $pdf_file = $temp_dir . DIRECTORY_SEPARATOR . 'invoice_' . $unique_id . '.pdf';

    // Save LaTeX content to the temporary .tex file
    file_put_contents($tex_file, $latex_content);

    // Set PATH environment variable for Perl in PHP
    $perl_path = 'C:\Strawberry\perl\bin';
    $current_path = getenv('PATH');
    putenv("PATH=$current_path;$perl_path");

    // Run latexmk with XeLaTeX to compile the LaTeX file to PDF
    $latexmk_path = '"C:\\Users\\Sandip Paria\\AppData\\Local\\Programs\\MiKTeX\\miktex\\bin\\x64\\latexmk.exe"';
    $latexmk_command = "$latexmk_path -xelatex -outdir=\"$temp_dir\" \"$tex_file\" 2>&1";
    $output = shell_exec($latexmk_command);

    // Check if PDF was generated
    if (file_exists($pdf_file)) {
        // Clean any previous output buffer
        ob_clean();

        // Set headers to send the PDF file to the browser
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($pdf_file));

        // Output the PDF file
        readfile($pdf_file);

        // Clean up temporary files
        unlink($tex_file);
        unlink($pdf_file);

        // Exit to prevent any additional output
        exit;
    } else {
        // Log the latexmk output for debugging
        error_log("latexmk output: " . $output);
        ob_clean();
        die("Failed to generate PDF. Check server logs for details. Temp dir: " . $temp_dir);
    }
} else {
    ob_clean();
    die("Invalid request.");
}
?>