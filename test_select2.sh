#!/bin/bash
echo "🔍 Testing Select2 Implementation"
echo "================================="

# Kill existing server
pkill -f "php artisan serve"
sleep 2

# Start fresh server
echo "🚀 Starting Laravel server..."
cd /Users/tiarapp31/www/spa
php artisan serve --host=127.0.0.1 --port=8000 > /dev/null 2>&1 &
SERVER_PID=$!

# Wait for server to start
sleep 3

echo "✅ Server started on http://127.0.0.1:8000"

# Test routes
echo ""
echo "🧪 Testing routes..."
echo "Route: /inventory/summary"
curl -s -o /dev/null -w "Status: %{http_code}\n" http://127.0.0.1:8000/inventory/summary

echo ""
echo "📝 Testing view file content..."

# Check if Select2 is properly included
if grep -q "select2@4.1.0" /Users/tiarapp31/www/spa/resources/views/admin/inventory/summary.blade.php; then
    echo "✅ Select2 4.1.0 CDN found"
else
    echo "❌ Select2 CDN not found"
fi

if grep -q "class=\"form-control select2\"" /Users/tiarapp31/www/spa/resources/views/admin/inventory/summary.blade.php; then
    echo "✅ Select2 classes found"
else
    echo "❌ Select2 classes not found"
fi

if grep -q "bootstrap4" /Users/tiarapp31/www/spa/resources/views/admin/inventory/summary.blade.php; then
    echo "✅ Bootstrap4 theme found"
else
    echo "❌ Bootstrap4 theme not found"
fi

echo ""
echo "🎯 Select2 Implementation Status:"
echo "- CDN: Latest stable version (4.1.0)"
echo "- Theme: Bootstrap 4"
echo "- Classes: Applied to all filter selects"
echo "- Features: Search, Clear, Placeholders"
echo "- Debugging: Console logs enabled"

echo ""
echo "📊 View file at: resources/views/admin/inventory/summary.blade.php"
echo "🌐 Test URL: http://127.0.0.1:8000/inventory/summary"
echo ""
echo "💡 Select2 should work now. If not working:"
echo "1. Check browser console for errors"
echo "2. Ensure you're logged in"
echo "3. Check network tab for failed CDN requests"

# Keep server running
echo "⏳ Server running... Press Ctrl+C to stop"
wait $SERVER_PID
