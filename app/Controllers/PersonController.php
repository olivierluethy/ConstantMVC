<?php
/**
 * =============================================================================
 * ConstantMVC — Person controller (the "C" in MVC)
 * =============================================================================
 *
 * The controller is the coordinator. For each route it:
 *   1. reads the request (form input, ?id=...),
 *   2. asks the Validator to check the input,
 *   3. tells the Model what to do with the database,
 *   4. either renders a View or redirects back to the list.
 *
 * It contains NO SQL and NO HTML — those belong to the Model and the Views.
 */

final class PersonController
{
    private Person $people;

    public function __construct()
    {
        $this->people = new Person();
    }

    /**
     * GET /  — show the list of people (with the Add/Edit/Delete modals).
     */
    public function index(): void
    {
        view('people/index', [
            'people' => $this->people->all(),
        ]);
    }

    /**
     * POST /create — handle the "Add person" modal form.
     */
    public function store(): void
    {
        ['data' => $data, 'errors' => $errors] = Validator::validate($_POST);

        if ($errors) {
            // Remember what was typed so the modal can re-open pre-filled.
            remember_input($data, $errors);
            flash('error', 'Please fix the highlighted fields.');
            redirect();
        }

        $this->people->create($data);
        flash('success', 'Person added.');
        redirect(); // Post/Redirect/Get — back to the list.
    }

    /**
     * POST /update?id=… — handle the "Edit person" modal form.
     */
    public function update(): void
    {
        $id = $this->requireId();

        ['data' => $data, 'errors' => $errors] = Validator::validate($_POST);

        if ($errors) {
            remember_input($data + ['id' => $id], $errors);
            flash('error', 'Please fix the highlighted fields.');
            redirect();
        }

        $this->people->update($id, $data);
        flash('success', 'Person updated.');
        redirect();
    }

    /**
     * POST /delete?id=… — handle the "Delete" confirmation modal.
     */
    public function destroy(): void
    {
        $this->people->delete($this->requireId());
        flash('success', 'Person deleted.');
        redirect();
    }

    /**
     * Read and validate the ?id= query parameter, or stop with a 400.
     */
    private function requireId(): int
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            http_response_code(400);
            exit('Missing or invalid id.');
        }
        return $id;
    }
}
