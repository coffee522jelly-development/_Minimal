# Daisy Corp - Minimalist Corporate WordPress Theme

Daisy Corp is a high-functionality, minimalist WordPress theme built with **DaisyUI v5** and **Tailwind CSS v4**. It is specifically optimized for corporate information architecture and a superior reading experience.

## ✨ Features

### 🏢 Corporate Information Architecture
- **3-Level Hierarchical Category Tree:** A custom widget and shortcode (`[category_tree]`) that displays your categories up to 3 levels deep with live post counts.
- **Dynamic Footer:** Three fully widgetized footer columns for modular company information.
- **Hierarchical Navigation:** Support for multi-level page structures in both the header and footer.
- **Customizable Contact Button:** Set your own destination URL and label for the primary header action.

### 📖 Enhanced Reading Experience
- **Automated "3-Piece Set":** Every post and page automatically displays Breadcrumbs, a Table of Contents (TOC), and an Estimated Reading Time in a cohesive, minimalist block.
- **TOC Generator:** Automatically parses H2 and H3 tags to create a minimalist, smooth-scrolling table of contents with a customizable header title.
- **Japanese-Optimized Reading Time:** Accurate estimates calculated at 500 characters per minute.
- **Focused Layouts:** Content area constrained to a readable width (`max-w-4xl`) with generous professional spacing.
- **Minimalist Author Box:** A subtle section at the end of posts featuring the author's gravatar and bio.

### 🎨 Deep Customization (via WordPress Customizer)
- **32 DaisyUI Themes:** Choose from all default DaisyUI presets (Light, Dark, Retro, Cupcake, Synthwave, etc.).
- **Brand Color Overrides:** Manually set your site's **Primary** and **Secondary** colors regardless of the chosen theme.
- **Flexible Grid:** Choice of **1, 2, or 4 columns** for blog and archive listings (intelligently enforced 1-column on mobile).
- **Layout Toggles:**
  - Sidebar Position: Left or Right.
  - Menu Position: Center or Right.
  - Sidebar Visibility: Option to hide the sidebar on single posts/pages for a focused view.
- **Advanced Typography:**
  - **Web Font Selector:** Choose from several professional Google Fonts (Inter, Noto Sans JP, Roboto, etc.).
  - **Base Font Size:** Adjust the global text size (icons will automatically scale to match!).

### 📱 Mobile-First Design
- **Enforced Mobile Grid:** Cards are strictly 1-column on smartphones for clarity.
- **Touch-Optimized Menu:** Large hit areas and a wide mobile drawer.
- **Responsive Media:** Aspect-ratio controlled thumbnails (aspect-video on mobile).
- **Back to Top:** A subtle floating button for mobile users.

### 🛠 Technical Excellence
- **Tech Stack:** Tailwind CSS v4 + DaisyUI v5.
- **Feather Icons:** High-quality, auto-scaling icons integrated via CDN.
- **Custom Nav Walker:** Seamlessly bridges WordPress menu logic with DaisyUI dropdown markup.
- **Clean Code:** Secure escaping and sanitization throughout.

## 🚀 Installation

1. **Download:** ZIP the contents of this repository.
2. **Upload:** Go to **Appearance > Themes > Add New > Upload Theme** in your WordPress dashboard.
3. **Activate:** Upload the ZIP and click **Activate**.
4. **Setup:**
   - Create your menu in **Appearance > Menus** and assign it to the **Primary** location.
   - Configure your site identity and brand colors in **Appearance > Customize > Theme Settings**.
   - Add the **Daisy Corp Category Tree** widget and other content to your sidebars in **Appearance > Widgets**.

## 🛠 For Developers

This theme is ready for further customization.
- **Styles:** Edit `src/style.css` to add custom Tailwind layers or overrides.
- **Build:** Run `npm install` and then `npm run build` to re-generate the `dist/output.css`.
- **Watch:** Use `npm run watch` during development.

---
Built with ❤️ for professional corporate minimalism.
