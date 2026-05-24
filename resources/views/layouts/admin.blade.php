{{-- C:\Users\HP\Desktop\Lumiere\resources\views\layouts\admin.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'LUMIÈRE · Atelier Control')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Jost:wght@200;300;400;500;600&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:       #0E0E0F;
  --surface:  #161618;
  --surface2: #1E1E21;
  --surface3: #252528;
  --border:   rgba(255,255,255,0.06);
  --border2:  rgba(255,255,255,0.10);
  --gold:     #C9A84C;
  --gold-dim: rgba(201,168,76,0.12);
  --gold-glow:rgba(201,168,76,0.06);
  --text:     rgba(255,255,255,0.88);
  --text-mid: rgba(255,255,255,0.50);
  --text-dim: rgba(255,255,255,0.28);
  --green:    #4CAF7D;
  --red:      #E05252;
  --amber:    #D4924A;
  --sidebar-w:240px;
  --sidebar-collapsed:64px;
}
html,body{height:100%;overflow:hidden}
body{font-family:'Jost',sans-serif;background:var(--bg);color:var(--text);display:flex}

/* â”€â”€ SCROLLBAR â”€â”€ */
::-webkit-scrollbar{width:4px;height:4px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:rgba(201,168,76,0.25);border-radius:4px}
::selection{background:var(--gold);color:#000}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   SIDEBAR
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.sidebar{
  width:var(--sidebar-w);
  min-height:100vh;
  background:var(--surface);
  border-right:1px solid var(--border);
  display:flex;flex-direction:column;
  flex-shrink:0;
  transition:width 0.35s cubic-bezier(0.4,0,0.2,1);
  overflow:hidden;
  position:relative;z-index:10;
}
.sidebar.collapsed{width:var(--sidebar-collapsed)}

.sb-logo{
  padding:22px 20px 18px;
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;gap:12px;
  min-height:64px;
  flex-shrink:0;
}
.sb-logo-text{
  font-family:'Playfair Display',serif;
  font-size:1rem;letter-spacing:0.22em;
  color:var(--text);white-space:nowrap;
  transition:opacity 0.25s,width 0.25s;
}
.sidebar.collapsed .sb-logo-text{opacity:0;width:0;overflow:hidden}
.sb-logo-mark{
  width:28px;height:28px;border-radius:50%;
  border:1px solid rgba(201,168,76,0.4);
  display:flex;align-items:center;justify-content:center;
  flex-shrink:0;
}
.sb-logo-mark i{color:var(--gold);font-size:0.7rem}

.sb-toggle{
  position:absolute;bottom:24px;left:50%;transform:translateX(-50%);
  width:28px;height:28px;border-radius:50%;
  background:var(--surface3);border:1px solid var(--border2);
  display:flex;align-items:center;justify-content:center;
  cursor:pointer;color:var(--text-dim);font-size:0.6rem;
  transition:color 0.2s,background 0.2s;
  flex-shrink:0;
}
.sb-toggle:hover{color:var(--gold);background:var(--gold-dim)}

.sb-nav{flex:1;overflow-y:auto;overflow-x:hidden;padding:12px 0}

.sb-section-label{
  font-size:0.52rem;letter-spacing:0.3em;color:var(--text-dim);
  padding:16px 20px 6px;white-space:nowrap;
  transition:opacity 0.25s;
}
.sidebar.collapsed .sb-section-label{opacity:0}

.sb-item{
  display:flex;align-items:center;gap:12px;
  padding:10px 20px;cursor:pointer;
  border-left:2px solid transparent;
  transition:background 0.2s,border-color 0.2s,color 0.2s;
  color:var(--text-mid);white-space:nowrap;
  font-size:0.72rem;letter-spacing:0.08em;font-weight:300;
  position:relative;
}
.sb-item:hover{background:var(--gold-glow);color:var(--text)}
.sb-item.active{
  background:var(--gold-dim);border-left-color:var(--gold);
  color:var(--text);
}
.sb-item i{width:16px;text-align:center;font-size:0.78rem;flex-shrink:0}
.sb-item-label{transition:opacity 0.25s,width 0.25s;white-space:nowrap}
.sidebar.collapsed .sb-item-label{opacity:0;width:0;overflow:hidden}

.sb-badge{
  margin-left:auto;background:var(--gold);color:#000;
  font-size:0.55rem;font-weight:600;
  min-width:16px;height:16px;border-radius:8px;
  display:flex;align-items:center;justify-content:center;padding:0 4px;
  flex-shrink:0;
  transition:opacity 0.25s;
}
.sidebar.collapsed .sb-badge{opacity:0}

/* Tooltip for collapsed */
.sidebar.collapsed .sb-item:hover::after{
  content:attr(data-label);
  position:absolute;left:calc(var(--sidebar-collapsed) + 8px);
  background:var(--surface3);color:var(--text);
  font-size:0.7rem;padding:6px 10px;border-radius:4px;
  white-space:nowrap;border:1px solid var(--border2);
  pointer-events:none;z-index:100;
}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   MAIN AREA
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.main{flex:1;display:flex;flex-direction:column;overflow:hidden}

.topbar{
  height:64px;padding:0 32px;
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;
  flex-shrink:0;background:var(--surface);
}
.topbar-title{
  font-family:'Playfair Display',serif;
  font-size:1.1rem;font-weight:400;color:var(--text);
  letter-spacing:0.04em;
}
.topbar-right{display:flex;align-items:center;gap:16px}
.topbar-btn{
  width:32px;height:32px;border-radius:50%;
  background:var(--surface3);border:1px solid var(--border2);
  display:flex;align-items:center;justify-content:center;
  cursor:pointer;color:var(--text-mid);font-size:0.72rem;
  transition:color 0.2s,background 0.2s;
}
.topbar-btn:hover{color:var(--gold);background:var(--gold-dim)}

.topbar-avatar{
  width:32px;height:32px;border-radius:50%;
  background:var(--gold);display:flex;align-items:center;justify-content:center;
  font-size:0.65rem;font-weight:600;color:#000;letter-spacing:0.05em;cursor:pointer;
}
.topbar-date{font-size:0.62rem;color:var(--text-dim);letter-spacing:0.12em}

.content{flex:1;overflow-y:auto;padding:32px}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   SECTION PAGES
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.page{display:none}
.page.active{display:block;animation:pageIn 0.3s ease}
@keyframes pageIn{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   STAT CARDS
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px}
@media(max-width:1200px){.stats-grid{grid-template-columns:repeat(2,1fr)}}

.stat-card{
  background:var(--surface);border:1px solid var(--border);
  padding:22px 24px;position:relative;overflow:hidden;
}
.stat-card::before{
  content:'';position:absolute;top:0;right:0;
  width:60px;height:60px;
  background:radial-gradient(circle,var(--gold-glow) 0%,transparent 70%);
}
.stat-label{font-size:0.58rem;letter-spacing:0.25em;color:var(--text-dim);margin-bottom:10px}
.stat-value{
  font-family:'Playfair Display',serif;font-size:1.9rem;
  font-weight:400;color:var(--text);margin-bottom:6px;
}
.stat-sub{font-size:0.65rem;color:var(--text-dim);font-weight:300}
.stat-trend{
  position:absolute;top:22px;right:22px;
  font-size:0.65rem;font-weight:400;
  display:flex;align-items:center;gap:4px;
}
.stat-trend.up{color:var(--green)}
.stat-trend.down{color:var(--red)}
.stat-icon{
  position:absolute;bottom:16px;right:20px;
  font-size:1.4rem;color:rgba(201,168,76,0.08);
}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   TABLES
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.card{background:var(--surface);border:1px solid var(--border);margin-bottom:20px}
.card-head{
  padding:18px 24px;border-bottom:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;
}
.card-title{
  font-family:'Playfair Display',serif;font-size:0.95rem;
  font-weight:400;letter-spacing:0.04em;
}
.card-body{padding:0}

table{width:100%;border-collapse:collapse}
th{
  font-size:0.58rem;letter-spacing:0.22em;color:var(--text-dim);
  padding:12px 20px;text-align:left;border-bottom:1px solid var(--border);
  font-weight:400;background:var(--surface2);
}
td{
  padding:14px 20px;font-size:0.78rem;font-weight:300;color:var(--text-mid);
  border-bottom:1px solid var(--border);vertical-align:middle;
}
tr:last-child td{border-bottom:none}
tr:hover td{background:var(--gold-glow);color:var(--text)}

.badge{
  display:inline-flex;align-items:center;gap:4px;
  font-size:0.58rem;letter-spacing:0.12em;font-weight:400;
  padding:3px 9px;border-radius:2px;
}
.badge-green{background:rgba(76,175,125,0.12);color:var(--green)}
.badge-red{background:rgba(224,82,82,0.12);color:var(--red)}
.badge-amber{background:rgba(212,146,74,0.12);color:var(--amber)}
.badge-gold{background:var(--gold-dim);color:var(--gold)}
.badge-dim{background:rgba(255,255,255,0.05);color:var(--text-dim)}

.dot{width:6px;height:6px;border-radius:50%;display:inline-block}
.dot-green{background:var(--green)}
.dot-red{background:var(--red)}
.dot-amber{background:var(--amber)}
.dot-gold{background:var(--gold)}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   BUTTONS
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.btn{
  display:inline-flex;align-items:center;gap:8px;
  padding:9px 18px;font-family:'Jost',sans-serif;
  font-size:0.64rem;letter-spacing:0.2em;font-weight:400;
  cursor:pointer;border:none;transition:all 0.25s;
}
.btn-gold{background:var(--gold);color:#000}
.btn-gold:hover{background:#E8C97A}
.btn-outline{background:transparent;border:1px solid var(--border2);color:var(--text-mid)}
.btn-outline:hover{border-color:var(--gold);color:var(--gold)}
.btn-ghost{background:transparent;color:var(--text-mid);padding:6px 10px}
.btn-ghost:hover{color:var(--gold)}
.btn-danger{background:rgba(224,82,82,0.1);border:1px solid rgba(224,82,82,0.2);color:var(--red)}
.btn-danger:hover{background:rgba(224,82,82,0.2)}
.btn i{font-size:0.75rem}
.btn-sm{padding:6px 12px;font-size:0.6rem}

/* â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
   FORMS
â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â• */
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px}
.form-full{grid-column:1/-1}

.field{margin-bottom:0}
.field-label{
  display:block;font-size:0.58rem;letter-spacing:0.22em;
  color:var(--text-dim);margin-bottom:8px;font-weight:400;
}
.field-label span{color:var(--gold);margin-left:2px}

.lux-input,.lux-select,.lux-textarea{
  width:100%;background:var(--surface2);
  border:1px solid var(--border2);
  color:var(--text);font-family:'Jost',sans-serif;
  font-size:0.82rem;font-weight:300;
  padding:10px 14px;outline:none;
  transition:border-color 0.25s,background 0.25s;
  -webkit-appearance:none;
}
.lux-input:focus,.lux-select:focus,.lux-textarea:focus{
  border-color:var(--gold);background:var(--surface3);
}
.lux-input::placeholder,.lux-textarea::placeholder{color:var(--text-dim)}
.lux-select option{background:var(--surface2)}
.lux-textarea{resize:vertical;min-height:100px;line-height:1.6}

/* Rich text area */
.rich-toolbar{
  background:var(--surface3);border:1px solid var(--border2);
  border-bottom:none;padding:8px 12px;
  display:flex;gap:4px;flex-wrap:wrap;align-items:center;
}
.rich-btn{
  background:none;border:1px solid transparent;color:var(--text-mid);
  padding:4px 8px;font-size:0.72rem;cursor:pointer;
  transition:all 0.2s;border-radius:2px;font-family:'Jost',sans-serif;
}
.rich-btn:hover{background:var(--gold-dim);color:var(--gold);border-color:rgba(201,168,76,0.2)}
.rich-sep{width:1px;height:16px;background:var(--border2);margin:0 4px}
.rich-content{
  width:100%;min-height:320px;background:var(--surface2);
  border:1px solid var(--border2);color:var(--text);
  font-family:'Jost',sans-serif;font-size:0.84rem;font-weight:300;
  padding:16px;outline:none;line-height:1.7;
}
.rich-content:focus{border-color:var(--gold);background:var(--surface3)}
.rich-content p{margin-bottom:12px}
.rich-content:empty::before{content:attr(data-placeholder);color:var(--text-dim)}

/* Image upload zone */
.upload-zone{
  border:1px dashed var(--border2);padding:32px;
  text-align:center;cursor:pointer;
  transition:border-color 0.25s,background 0.25s;
  background:var(--surface2);
}
.upload-zone:hover,.upload-zone.drag{border-color:var(--gold);background:var(--gold-glow)}
.upload-zone i{font-size:1.6rem;color:var(--text-dim);margin-bottom:10px;display:block}
.upload-zone p{font-size:0.72rem;color:var(--text-dim);font-weight:300;line-height:1.6}
.upload-zone strong{color:var(--gold)}

/* Image preview grid */
.image-previews{display:flex;gap:10px;flex-wrap:wrap;margin-top:12px}
.img-preview{
  position:relative;width:80px;height:80px;
  border:1px solid var(--border2);overflow:hidden;
}
.img-preview img{width:100%;height:100%;object-fit:cover}
.img-preview-remove{
  position:absolute;top:2px;right:2px;
  width:18px;height:18px;border-radius:50%;
  background:rgba(0,0,0,0.8);color:#fff;
  border:none;cursor:pointer;font-size:0.55rem;
  display:flex;align-items:center;justify-content:center;
}
.img-primary-badge{
  position:absolute;bottom:0;left:0;right:0;
  background:rgba(201,168,76,0.85);
  font-size:0.5rem;letter-spacing:0.12em;color:#000;
  text-align:center;padding:2px 0;font-weight:500;
}

/* Variant rows */
.variant-row{
  display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr 80px 36px;
  gap:8px;align-items:center;margin-bottom:8px;
  padding:10px 14px;background:var(--surface2);border:1px solid var(--border);
}
.variant-row:first-child{border-top-color:var(--gold)}

/* Attribute rows */
.attr-row{
  display:grid;grid-template-columns:1fr 1fr 80px 36px;
  gap:8px;align-items:center;margin-bottom:8px;
}

/* Toggle switch */
.toggle-wrap{display:flex;align-items:center;gap:10px}
.toggle{
  width:38px;height:20px;border-radius:20px;
  background:var(--surface3);border:1px solid var(--border2);
  position:relative;cursor:pointer;transition:background 0.3s,border-color 0.3s;
  flex-shrink:0;
}
.toggle.on{background:var(--gold);border-color:var(--gold)}
.toggle-thumb{
  position:absolute;top:2px;left:2px;
  width:14px;height:14px;border-radius:50%;
  background:var(--text-dim);
  transition:transform 0.3s cubic-bezier(0.34,1.56,0.64,1),background 0.3s;
}
.toggle.on .toggle-thumb{transform:translateX(18px);background:#000}
.toggle-label{font-size:0.72rem;color:var(--text-mid);font-weight:300}

/* Form sidebar (right column) */
.form-layout{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start}
.form-sidebar-card{
  background:var(--surface);border:1px solid var(--border);
  padding:0;position:sticky;top:0;
}
.form-sidebar-section{padding:18px 20px;border-bottom:1px solid var(--border)}
.form-sidebar-section:last-child{border-bottom:none}
.form-sidebar-title{font-size:0.6rem;letter-spacing:0.22em;color:var(--text-dim);margin-bottom:14px}

/* Status pill selector */
.status-pills{display:flex;flex-direction:column;gap:6px}
.status-pill{
  display:flex;align-items:center;gap:10px;
  padding:8px 12px;cursor:pointer;
  border:1px solid var(--border);
  transition:border-color 0.2s,background 0.2s;
  font-size:0.72rem;color:var(--text-mid);font-weight:300;
}
.status-pill.selected{border-color:var(--gold);background:var(--gold-dim);color:var(--text)}
.status-pill input{display:none}

/* Page header */
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
.page-header-left{}
.page-eyebrow{font-size:0.58rem;letter-spacing:0.3em;color:var(--gold);margin-bottom:4px}
.page-title{
  font-family:'Playfair Display',serif;font-size:1.6rem;
  font-weight:400;letter-spacing:0.03em;color:var(--text);
}

/* Two-column layout for lists */
.list-filters{
  display:flex;align-items:center;gap:10px;margin-bottom:16px;flex-wrap:wrap;
}
.filter-pill{
  padding:6px 14px;background:var(--surface2);border:1px solid var(--border);
  font-size:0.62rem;letter-spacing:0.14em;color:var(--text-mid);
  cursor:pointer;transition:all 0.2s;
}
.filter-pill.active,.filter-pill:hover{border-color:var(--gold);color:var(--gold);background:var(--gold-dim)}

.search-input{
  background:var(--surface2);border:1px solid var(--border2);
  color:var(--text);font-family:'Jost',sans-serif;font-size:0.78rem;
  font-weight:300;padding:7px 14px;outline:none;
  transition:border-color 0.25s;min-width:220px;
}
.search-input:focus{border-color:var(--gold)}
.search-input::placeholder{color:var(--text-dim)}

/* Tabs inside pages */
.inner-tabs{display:flex;gap:0;border-bottom:1px solid var(--border);margin-bottom:24px}
.inner-tab{
  padding:10px 20px;font-size:0.65rem;letter-spacing:0.18em;
  color:var(--text-dim);cursor:pointer;border-bottom:2px solid transparent;
  transition:color 0.2s,border-color 0.2s;font-weight:300;
}
.inner-tab.active{color:var(--gold);border-bottom-color:var(--gold)}
.inner-tab:hover{color:var(--text-mid)}

/* Inline action buttons in table */
.action-group{display:flex;align-items:center;gap:6px}
.action-btn{
  width:28px;height:28px;border-radius:3px;
  background:transparent;border:1px solid var(--border);
  color:var(--text-dim);cursor:pointer;font-size:0.65rem;
  display:flex;align-items:center;justify-content:center;
  transition:all 0.2s;
}
.action-btn:hover{border-color:var(--gold);color:var(--gold);background:var(--gold-dim)}
.action-btn.danger:hover{border-color:var(--red);color:var(--red);background:rgba(224,82,82,0.1)}

/* Product image thumb in table */
.prod-thumb{
  width:44px;height:44px;object-fit:cover;
  border:1px solid var(--border);display:block;
}

/* Commission/Bespoke timeline */
.timeline{display:flex;gap:0;margin-bottom:28px;overflow-x:auto;padding-bottom:4px}
.tl-step{
  flex:1;display:flex;flex-direction:column;align-items:center;
  position:relative;min-width:90px;
}
.tl-step::before{
  content:'';position:absolute;top:13px;left:50%;right:-50%;
  height:1px;background:var(--border2);z-index:0;
}
.tl-step:last-child::before{display:none}
.tl-dot{
  width:26px;height:26px;border-radius:50%;
  border:1px solid var(--border2);background:var(--surface2);
  display:flex;align-items:center;justify-content:center;
  font-size:0.58rem;color:var(--text-dim);
  position:relative;z-index:1;margin-bottom:8px;
  transition:all 0.3s;
}
.tl-step.done .tl-dot{background:var(--gold);border-color:var(--gold);color:#000}
.tl-step.active .tl-dot{background:var(--surface3);border-color:var(--gold);color:var(--gold)}
.tl-label{font-size:0.58rem;letter-spacing:0.1em;color:var(--text-dim);text-align:center;white-space:nowrap}
.tl-step.done .tl-label,.tl-step.active .tl-label{color:var(--text-mid)}

/* Notification dot */
.notif-dot{
  width:7px;height:7px;border-radius:50%;background:var(--red);
  position:absolute;top:6px;right:6px;
}

/* Divider */
.divider{height:1px;background:var(--border);margin:20px 0}

/* Empty state */
.empty-state{
  text-align:center;padding:60px 20px;
  color:var(--text-dim);
}
.empty-state i{font-size:2rem;margin-bottom:14px;display:block;color:rgba(201,168,76,0.2)}
.empty-state p{font-size:0.78rem;font-weight:300;line-height:1.7}

/* Toast */
#toast{
  position:fixed;bottom:28px;right:28px;z-index:1000;
  background:var(--surface3);border:1px solid var(--gold);
  color:var(--text);padding:14px 20px;
  font-size:0.75rem;font-weight:300;letter-spacing:0.04em;
  display:flex;align-items:center;gap:10px;
  transform:translateY(80px);opacity:0;
  transition:transform 0.4s cubic-bezier(0.34,1.56,0.64,1),opacity 0.4s;
  max-width:320px;
}
#toast.show{transform:translateY(0);opacity:1}
#toast i{color:var(--gold)}

/* Scrollable wrapper */
.scroll{overflow-y:auto}

/* Two col quick layout */
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.three-col{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}

/* Progress bar */
.progress-bar{height:3px;background:var(--surface3);border-radius:2px;margin-top:6px}
.progress-fill{height:100%;background:var(--gold);border-radius:2px;transition:width 0.6s ease}

/* Chip */
.chip{
  display:inline-flex;align-items:center;gap:5px;
  padding:3px 10px;border-radius:2px;
  background:var(--surface3);border:1px solid var(--border2);
  font-size:0.62rem;color:var(--text-mid);letter-spacing:0.08em;
}

/* Quick stats bar under table header */
.quick-stats{display:flex;gap:24px;padding:12px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
.qs{font-size:0.65rem;color:var(--text-dim)}
.qs strong{color:var(--text);font-weight:400;margin-left:4px}
</style>
</head>
<body>

<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <div class="sb-logo-mark"><i class="fa-solid fa-gem"></i></div>
    <span class="sb-logo-text">LUMIÈRE</span>
  </div>

  <nav class="sb-nav">
    <div class="sb-section-label">OVERVIEW</div>
    <a class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-label="Dashboard" href="{{ route('admin.dashboard') }}">
      <i class="fa-solid fa-chart-line"></i>
      <span class="sb-item-label">Dashboard</span>
    </a>

    <div class="sb-section-label">CATALOGUE</div>
    <a class="sb-item {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.edit') ? 'active' : '' }}" data-label="Products" href="{{ route('admin.products.index') }}">
      <i class="fa-solid fa-gem"></i>
      <span class="sb-item-label">Products</span>
      <span class="sb-badge">{{ $adminProductCount ?? '' }}</span>
    </a>
    <a class="sb-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}" data-label="Add Product" href="{{ route('admin.products.create') }}">
      <i class="fa-solid fa-circle-plus"></i>
      <span class="sb-item-label">Add Product</span>
    </a>
    <a class="sb-item {{ request()->routeIs('admin.collections.*') ? 'active' : '' }}" data-label="Collections" href="{{ route('admin.collections.index') }}">
      <i class="fa-solid fa-layer-group"></i>
      <span class="sb-item-label">Collections</span>
    </a>

    <div class="sb-section-label">JOURNAL</div>
    <a class="sb-item {{ request()->routeIs('admin.posts.index') || request()->routeIs('admin.posts.edit') ? 'active' : '' }}" data-label="All Stories" href="{{ route('admin.posts.index') }}">
      <i class="fa-solid fa-book-open"></i>
      <span class="sb-item-label">All Stories</span>
      <span class="sb-badge">{{ $adminPostCount ?? '' }}</span>
    </a>
    <a class="sb-item {{ request()->routeIs('admin.posts.create') ? 'active' : '' }}" data-label="New Story" href="{{ route('admin.posts.create') }}">
      <i class="fa-solid fa-pen-nib"></i>
      <span class="sb-item-label">New Story</span>
    </a>

    <div class="sb-section-label">COMMERCE</div>
    <a class="sb-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" data-label="Orders" href="{{ route('admin.orders.index') }}">
      <i class="fa-solid fa-bag-shopping"></i>
      <span class="sb-item-label">Orders</span>
      <span class="sb-badge" style="background:var(--red)">{{ $adminPendingOrderCount ?? '' }}</span>
    </a>
    <a class="sb-item {{ request()->routeIs('admin.bespoke.*') ? 'active' : '' }}" data-label="Bespoke" href="{{ route('admin.bespoke.index') }}">
      <i class="fa-solid fa-wand-magic-sparkles"></i>
      <span class="sb-item-label">Bespoke</span>
    </a>

    <div class="sb-section-label">PEOPLE</div>
    <a class="sb-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-label="Customers" href="{{ route('admin.users.index') }}">
      <i class="fa-solid fa-users"></i>
      <span class="sb-item-label">Customers</span>
    </a>
  </nav>

  <div class="sb-toggle" onclick="toggleSidebar()" title="Toggle sidebar">
    <i class="fa-solid fa-chevron-left" id="sb-toggle-icon"></i>
  </div>
</aside>

<div class="main">
  <div class="topbar">
    <span class="topbar-title" id="topbar-title">@yield('page-title', 'Dashboard')</span>
    <div class="topbar-right">
      <span class="topbar-date" id="topbar-date"></span>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="topbar-btn" title="Log out" type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
      </form>
      <div class="topbar-avatar">{{ strtoupper(substr(auth('admin')->user()?->name ?? 'LA', 0, 1).substr(strrchr(auth('admin')->user()?->name ?? 'Admin', ' ') ?: 'A', 1, 1)) }}</div>
    </div>
  </div>

  <div class="content">
    @if (session('status'))
      <div class="card" style="border-color:rgba(201,168,76,0.2);padding:14px 20px;margin-bottom:20px;color:var(--gold);font-size:0.72rem;letter-spacing:0.08em">{{ session('status') }}</div>
    @endif
    @yield('content')
  </div>
</div>

<div id="toast"><i class="fa-solid fa-check-circle"></i><span id="toast-msg">Saved</span></div>

<script>
const d = new Date();
document.getElementById('topbar-date').textContent =
  d.toLocaleDateString('en-GB',{weekday:'short',day:'numeric',month:'long',year:'numeric'}).toUpperCase();

function toggleSidebar(){
  const sb = document.getElementById('sidebar');
  const icon = document.getElementById('sb-toggle-icon');
  sb.classList.toggle('collapsed');
  icon.className = sb.classList.contains('collapsed')
    ? 'fa-solid fa-chevron-right'
    : 'fa-solid fa-chevron-left';
}

function slugify(s){return s.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,'')}
function autoSlug(){
  const name = document.getElementById('prod-name')?.value || '';
  const slug = document.getElementById('prod-slug');
  if(slug) slug.value = slugify(name);
}
function autoStorySlug(){
  const title = document.getElementById('story-title')?.value || '';
  const slug = document.getElementById('story-slug');
  if(slug) slug.value = slugify(title);
}
</script>
@stack('scripts')
</body>
</html>
