<?php 

include('../layout/header.php'); 
include('../layout/sidebar.php'); 

?>

  <!-- Main Content -->
  <main class="flex-1 h-screen overflow-y-auto p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-6"> Audit Logs</h1>

      <!-- Search & Filter -->
      <form method="get" class="mb-6 flex gap-4">
          <input type="text" name="search" placeholder="Search by user or details..." value="<?php echo htmlspecialchars($search); ?>"
              class="px-4 py-2 border rounded w-1/3" />

          <select name="type" class="px-4 py-2 border rounded">
              <option value="">All Types</option>
              <?php
              $types = ["Message Sent", "System Activity", "Staff Alert", "Mass SMS", "System Change", "Hotline Change"];
              foreach ($types as $type) {
                  $selected = ($filter_type === $type) ? "selected" : "";
                  echo "<option value=\"$type\" $selected>$type</option>";
              }
              ?>
          </select>

          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
          <a href="audit.php" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Reset</a>
      </form>

      <div class="bg-white p-6 rounded-xl shadow">
          <table class="w-full border-collapse">
              <thead>
                  <tr class="bg-gray-200 text-gray-700 text-left">
                      <th class="p-3">#</th>
                      <th class="p-3">Actor</th>
                      <th class="p-3">Role</th>
                      <th class="p-3">Action Details</th>
                      <th class="p-3">Type</th>
                      <th class="p-3">IP Address</th>
                      <th class="p-3">Timestamp</th>
                      <th class="p-3">Action</th>
                  </tr>
              </thead>
              <tbody>
                  <?php if (!empty($audit_logs)): ?>
                      <?php foreach ($audit_logs as $index => $log): ?>
                          <tr class="border-b hover:bg-gray-50">
                              <td class="p-3 text-sm text-gray-500"><?php echo $offset + $index + 1; ?></td>
                              <td class="p-3 font-semibold"><?php echo htmlspecialchars($log['username']); ?></td>
                              <td class="p-3 text-sm text-gray-600"><?php echo ucfirst($log['actor_role']); ?></td>
                              <td class="p-3"><?php echo htmlspecialchars($log['details']); ?></td>
                              <td class="p-3 text-sm font-medium
                                  <?php
                                      if ($log['log_type'] === 'Staff Alert') echo 'text-red-600';
                                      elseif ($log['log_type'] === 'Mass SMS') echo 'text-blue-600';
                                      elseif ($log['log_type'] === 'System Change') echo 'text-purple-600';
                                      elseif ($log['log_type'] === 'Hotline Change') echo 'text-green-600';
                                      else echo 'text-gray-700';
                                  ?>">
                                  <?php echo $log['log_type']; ?>
                              </td>
                              <td class="p-3 text-sm text-gray-500"><?php echo $log['ip_address'] ? $log['ip_address'] : "-"; ?></td>
                              <td class="p-3 text-sm text-gray-500">
                                  <?php echo date("M d, Y H:i:s", strtotime($log['timestamp'])); ?>
                              </td>
                              <td class="p-3">
                                  <button onclick="showDetails('<?php echo $log['log_id']; ?>')" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">View</button>
                              </td>
                          </tr>

                          <!-- Modal -->
                          <div id="auditModal-<?php echo $log['log_id']; ?>" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                              <div class="bg-white rounded-xl p-6 w-2/3 max-w-2xl shadow-lg">
                                  <h2 class="text-2xl font-bold mb-4 text-gray-800">Log Details</h2>

                                  <p><strong>Actor:</strong> <?php echo htmlspecialchars($log['full_name']); ?></p>
                                  <p><strong>Role:</strong> <?php echo ucfirst($log['actor_role']); ?></p>
                                  <p><strong>Type:</strong> <?php echo $log['log_type']; ?></p>
                                  <p><strong>IP Address:</strong> <?php echo $log['ip_address'] ? $log['ip_address'] : "N/A"; ?></p>
                                  <p><strong>Timestamp:</strong> <?php echo date("M d, Y H:i:s", strtotime($log['timestamp'])); ?></p>

                                  <p class="mt-4"><strong>Details:</strong></p>
                                  <div class="bg-gray-100 p-4 rounded mt-2 text-gray-700">
                                      <?php echo nl2br(htmlspecialchars($log['details'])); ?>
                                  </div>

                                  <div class="mt-6 text-right">
                                      <button onclick="closeDetails('<?php echo $log['log_id']; ?>')" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Close</button>
                                  </div>
                              </div>
                          </div>
                      <?php endforeach; ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="8" class="p-6 text-center text-gray-500">No logs available.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
          </table>

          <!-- Pagination -->
          <div class="flex justify-between items-center mt-6">
              <?php if ($page > 1): ?>
                  <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Previous</a>
              <?php else: ?>
                  <span class="px-4 py-2 bg-gray-200 rounded text-gray-500 cursor-not-allowed">Previous</span>
              <?php endif; ?>

              <span class="text-gray-700">Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>

              <?php if ($page < $total_pages): ?>
                  <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Next</a>
              <?php else: ?>
                  <span class="px-4 py-2 bg-gray-200 rounded text-gray-500 cursor-not-allowed">Next</span>
              <?php endif; ?>
          </div>
      </div>
  </main>

<?php
include('../layout/sidebar.php'); 
?>